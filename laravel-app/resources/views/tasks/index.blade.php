<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>To-Do List</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .task-item { padding: 10px; border-bottom: 1px solid #eee; }
        .task-item.completed { text-decoration: line-through; color: #888; }
        .empty-state { text-align: center; padding: 40px; color: #666; }
        .error { color: red; margin-bottom: 10px; }
        form { margin-bottom: 20px; }
        input[type="text"] { padding: 8px; width: 300px; }
        button { padding: 8px 16px; }
    </style>
</head>
<body>
    <h1>To-Do List</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <input type="text" name="title" placeholder="Enter task title" required>
        <button type="submit">Add Task</button>
        @if(isset($errors) && $errors->has('title'))
            <div class="error">{{ $errors->first('title') }}</div>
        @endif
    </form>

    @if($tasks->count() > 0)
        <ul>
            @foreach($tasks as $task)
                <li class="task-item {{ $task->completed ? 'completed' : '' }}">
                    <form action="{{ route('tasks.toggle', $task->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="checkbox" {{ $task->completed ? 'checked' : '' }} 
                               onChange="this.form.submit()">
                    </form>
                    
                    {{ $task->title }}
                    
                    <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                    
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <div class="empty-state">
            No tasks yet. Add your first task!
        </div>
    @endif
</body>
</html>