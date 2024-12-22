<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('tasks') }}
                <a href="{{ route('tasks.create') }}" style="float: right">
                    <h2>Create Task</h2>
                </a>
            </h2>

        </div>

    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="GET" action="{{ route('tasks.index') }}" class="filter-form mb-6">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Priorytet -->
                            <div class="form-field">
                                <label for="priority" class="form-label">Priority</label>
                                <select name="priority" id="priority" class="form-select">
                                    <option value="">Select Priority</option>
                                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low
                                    </option>
                                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>
                                        Medium</option>
                                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High
                                    </option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="form-field">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">Select Status</option>
                                    <option value="to-do" {{ request('status') == 'to-do' ? 'selected' : '' }}>To-do
                                    </option>
                                    <option value="in progress"
                                        {{ request('status') == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done
                                    </option>
                                </select>
                            </div>

                            <!-- Termin -->
                            <div class="form-field">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" name="due_date" id="due_date" value="{{ request('due_date') }}"
                                    class="form-input">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn-submit">Apply Filters</button>
                        </div>
                    </form>
                    
                    <h1 class="task-title">task List</h1>
                    <div class="task-list">
                        @foreach ($tasks as $task)
                            <a href="{{ route('tasks.show', $task) }}">
                                <div class="task-item">
                                    <div class="task-details">
                                        <h2 class="task-name">{{ $task->name }}</h2>
                                        <p class="task-description">{{ $task->description }}</p>
                                        <p class="task-meta">
                                            <span class="task-status task-in-progress">{{ $task->status }}</span>
                                            <span class="task-priority task-high">{{ $task->priority }}</span>
                                            <span class="task-date">Due: {{ $task->execution_date }}</span>
                                        </p>
                                    </div>
                                    <div class="task-actions">
                                        <a href="{{ route('tasks.edit', $task )}}"><button class="btn btn-edit">Edit</button></a>
                                        <form action="{{ route('tasks.generate-link', ['id' => $task->id]) }}" method="POST">

                                            @csrf
                                            <button type="submit" class="btn share-button">Share</button>
                                        </form>    
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-delete">Delete</button>

                                        </form>
                                    </div>

                                </div>
                            </a>
                        @endforeach
                        <h2>Your Google Calendar Events</h2>
                        @if(count($uniqueEvents) > 0)
                            @foreach ($uniqueEvents as $event)
                                <div class="task-item"> <!-- Use the same class as the task items -->
                                    <div class="task-details">
                                        <h2 class="task-name">{{ $event['summary'] }}</h2> <!-- Event name -->
                                        <p class="task-meta">
                                            <span class="task-status task-in-progress">Google Calendar</span> <!-- Custom label for calendar events -->
                                            <span class="task-date">Starts: {{ \Carbon\Carbon::parse($event['start']['dateTime'])->format('Y-m-d H:i') }}</span> <!-- Event date formatted -->
                                        </p>
                                    </div>
                                    <div class="task-actions">
                                        <!-- Add action buttons here if necessary, e.g., Edit, Delete, etc. -->
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No events found.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
