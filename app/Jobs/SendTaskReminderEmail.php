<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\taskReminder;
use Illuminate\Support\Facades\Mail;
use App\Models\Tasks;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class SendTaskReminderEmail implements ShouldQueue
{
    use Queueable;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tasks;

    /**
     * Create a new job ixnstance.
     */
    public function __construct()
    {
        log::info("dzialam1");

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        Log::info("Job started");
    
        $this->tasks = Tasks::whereDate('Execution_Date', '=', now()->addDay()->toDateString())
            ->where('status', '!=', 'completed')
            ->get();
        log::info("dzialam");
        foreach ($this->tasks as $task) {
            $user = User::find($task->user_id);
            Mail::to($user->email)->send(new taskReminder($task));
        }
      
    }
}
