<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use App\Models\Tasks;
use Illuminate\Http\Request;
use App\Models\TasksArch;
use App\Models\AccessToken;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Services\GoogleCalendarService;

class TasksController extends Controller
{

    private $googleCalendarService;

    public function __construct(GoogleCalendarService $googleCalendarService)
    {
        $this->googleCalendarService = $googleCalendarService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $priority = $request->input('priority');
        $status = $request->input('status');
        $due_date = $request->input('due_date');
        $events = [];
        if (session('google_access_token') && isset($this->googleCalendarService)) {
            try {
                // Jeśli wszystko jest poprawne, wywołaj listEvents
                $events = $this->googleCalendarService->listEvents();
            } catch (\Exception $e) {
                // Obsługuje wyjątek, jeśli wystąpi błąd przy pobieraniu wydarzeń
                // Możesz logować błąd lub przekazać odpowiednią wiadomość użytkownikowi
                Log::error('Google Calendar error: ' . $e->getMessage());
                // Może np. zwrócić komunikat o błędzie do widoku lub przekierować użytkownika
            }
        } 
        

        // Budowanie zapytania
        $tasks = Tasks::query()
            ->where('user_id', auth()->id())
            ->when($priority, function ($query, $priority) {
                return $query->where('priority', $priority);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($due_date, function ($query, $due_date) {
                return $query->whereDate('execution_date', '<=', $due_date);
            })
            ->orderBy('created_at', 'desc')
            ->paginate();

            $uniqueEvents = collect($events)->filter(function ($event) use ($tasks) {
                return !$tasks->contains(function ($task) use ($event) {
                    // Porównanie ID zadania w bazie z ID wydarzenia w kalendarzu
                    return $task->name === $event['summary']; // Możesz użyć innego pola do porównania, np. ID, jeśli jest dostępne
                });
            });

            return view('tasks.index', compact('tasks', 'uniqueEvents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request ->validate([
            'name'=> ['required','string'],
            'description' => 'string',
            'priority'=> ['required','string'],
            'status' => ['required','string'],
            'execution_date' => ['required','date_format:Y-m-d\TH:i'],
        ]);
        $data['user_id']=request()->user()->id;
        
        Tasks::create($data);
        
        // Dane do utworzenia wydarzenia w Google Calendar
        $startTime = Carbon::parse($data['execution_date']); // Parsowanie daty początkowej
        $endTime = $startTime->copy()->addHour(); // Dodanie 1 godziny do daty początkowej
        
        $eventData = [
            'summary' => $data['name'],
            'start' => [
                'dateTime' => $startTime->toIso8601String(), // Ustawienie daty początkowej
                'timeZone' => 'UTC',
            ],
            'end' => [
                'dateTime' => $endTime->toIso8601String(), // Ustawienie daty końcowej (start + 1 godzina)
                'timeZone' => 'UTC',
            ],
        ];

        Log::debug('Event data:', $eventData);
    

        // Wywołanie metody do dodania wydarzenia w Google Calendar
        $this->googleCalendarService->createEvent($eventData);   

      
        return to_route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tasks $task)
    {
        if ($task->user_id !== request()->user()->id) {
            abort(403);
        }
        $archivedTasks = TasksArch::where('task_id', $task->id)->get();

        return view('tasks.show', [
            'task' => $task,
            'archivedTasks' => $archivedTasks, // Przekazujemy archiwalne zadania do widoku
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tasks $task)
    {
        if ($task->user_id !== request()->user()->id) {
            Log::debug($task->user_id);
            Log::debug(request()->user()->id);
            abort(403);
        }
        return view('tasks.edit', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tasks $task)
    {
        if ($task->user_id !== request()->user()->id) {
            abort(403);
        }
        
        $data = $request ->validate([
            'name'=> ['required','string'],
            'description' => 'string',
            'priority'=> ['required','string'],
            'status' => ['required','string'],
            'execution_date' => ['required','date'],
        ]);
        $data['user_id']=request()->user()->id;
        
        $tempTask = Tasks::find($task->id);

        if ($tempTask) {
            $archData = $tempTask->toArray();
            $archData['task_id'] = $tempTask->id;
            TasksArch::create($archData);
        
        }
        $task->update($data);

        return to_route('tasks.index', $task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tasks $task)
    {
        // Usuwamy element z bazy danych
        $task->delete();
        return to_route('tasks.index');
    }

    public function generateShareLink($id)
    {
        $task = Tasks::findOrFail($id);

        // Wygeneruj token i okres ważności
        $token = Str::random(40);
        $expiresAt = Carbon::now()->addHours(24); // Token ważny przez 24 godziny

        // Zapisz token w bazie danych
        $accessToken = AccessToken::create([
            'task_id' => $task->id,
            'token' => $token,
            'expires_at' => $expiresAt,
        ]);

        $shareableLink = rtrim(route('tasks.check', ['id' => $task->id]), '/') . '?token=' . $accessToken->token;


        return view('tasks.shareLink',[
            'message' => 'Public link generated successfully',
            'link' => urldecode($shareableLink), // Dekodowanie linku, jeśli jest w odpowiedzi JSON
            'expires_at' => $expiresAt,
        ]);
    }

    public function viewTask($id)
    {
        $task = Tasks::findOrFail($id);
    
        // Opcjonalnie sprawdź token, jeśli to publiczny dostęp
        if (request()->has('token')) {
            $token = request('token');
    
            // Sprawdź, czy token jest poprawny i nie wygasł
            $isValid = AccessToken::where('task_id', $id)
                ->where('token', $token)
                ->where('expires_at', '>', now())
                ->exists();
    
            if (!$isValid) {
                abort(403, 'Unauthorized or token expired');
            }
        }
        $archivedTasks = TasksArch::where('task_id', $task->id)->get();
        return view('tasks.sharedTaskShow', [
            'task' => $task,
        ]);
    }

}
