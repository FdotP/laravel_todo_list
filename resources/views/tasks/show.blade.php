<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('View Task') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="form-title">Current Task Details</h1>
                    <div class="form-container">
                        <!-- Current Task Details -->
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Task Name:</label>
                                <p class="form-input" readonly>{{ $task->name }}</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Description:</label>
                                <p class="form-input" readonly>{{ $task->description }}</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Priority:</label>
                                <p class="form-input" readonly>{{ ucfirst($task->priority) }}</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status:</label>
                                <p class="form-input" readonly>{{ ucfirst(str_replace('-', ' ', $task->status)) }}</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Due Date:</label>
                                <p class="form-input" readonly>{{ $task->execution_date }}</p>
                            </div>
                        </div>
                        <!-- Action Buttons -->
                        <div class="form-row mt-6">
                            <a href="{{ route('tasks.edit', $task) }}" class="form-button" style="text-align: center;">Edit Task</a>
                            <form action="{{ route('tasks.generate-link', ['id' => $task->id]) }}" method="POST">

                                @csrf
                                <button type="submit" class="form-button share-button">Share</button>
                            </form>    
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="margin-left: 10px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="form-button" style="background-color: #e53935; color: white;">
                                    Delete Task
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Archived Versions -->
                    <h2 class="mt-8 mb-4 text-lg font-semibold">Archived Versions</h2>
                    @if ($archivedTasks->isEmpty())
                        <p>No archived versions found for this task.</p>
                    @else
                        @foreach ($archivedTasks as $archivedTask)
                            <div class="form-container border-t border-gray-300 mt-6 pt-4">
                                <h3 class="text-md font-bold">Archived Version</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Task Name:</label>
                                        <p class="form-input" readonly>{{ $archivedTask->name }}</p>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Description:</label>
                                        <p class="form-input" readonly>{{ $archivedTask->description }}</p>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Priority:</label>
                                        <p class="form-input" readonly>{{ ucfirst($archivedTask->priority) }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status:</label>
                                        <p class="form-input" readonly>{{ ucfirst(str_replace('-', ' ', $archivedTask->status)) }}</p>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Execution Date:</label>
                                        <p class="form-input" readonly>{{ $archivedTask->execution_date }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
