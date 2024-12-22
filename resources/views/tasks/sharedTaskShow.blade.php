<x-guest-layout>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>