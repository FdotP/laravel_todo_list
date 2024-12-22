<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit task') }}
            </h2>
            
        </div>
       
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h1 class="form-title">Create Task</h1>
                        <form action="{{route('tasks.update', $task)}}" method="POST" class="task-form">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <!-- Task Name -->
                                <div class="form-group">
                                    <label for="task-name" class="form-label" name='name'>Task Name:</label>
                                    <input type="text" id="task-name" name="name" class="form-input" maxlength="255" value="{{$task->name}}" required >
                                </div>
                
                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description" class="form-label">Description:</label>
                                    <textarea id="description" name="description" class="form-textarea" rows="4">{{$task->description}}</textarea>
                                </div>
                            </div>
                
                            <div class="form-row">
                                <!-- Priority -->
                                <div class="form-group">
                                    <label for="priority" class="form-label">Priority:</label>
                                    <select id="priority" name="priority" selected="{{$task->priority}}" class="form-select" >
                                        <option value="low" {{ ( $task->priority == 'low' ) ? 'selected' : '' }} >Low</option>
                                        <option value="medium" {{ ( $task->priority == 'medium' ) ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ ( $task->priority == 'high' ) ? 'selected' : '' }}>High</option>
                                    </select>
                                </div>
                
                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status" class="form-label">Status:</label>
                                    <select id="status" name="status"  class="form-select" >
                                        <option  {{ ( $task->status == 'to-Do' ) ? 'selected' : '' }} value="to-do">To-Do</option>
                                        <option  {{ ( $task->status == 'in-progress' ) ? 'selected' : '' }}  value="in-progress">In Progress</option>
                                        <option  {{ ( $task->status == 'done' ) ? 'selected' : '' }}  value="done">Done</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="form-row">
                                <!-- Due Date -->
                                <div class="form-group">
                                    <label for="due-date" class="form-label">Due Date:</label>
                                    <input type="date" id="due-date" name="execution_date" class="form-input" value="{{$task->execution_date}}" required >
                                </div>
                
                                <!-- Submit Button -->
                                <div class="form-group">
                                    <button type="submit" class="form-button">Save Task</button>
                                </div>
                            </div>
                        </form>
                  
            </div>
        </div>
    </div>
</x-app-layout>
