@extends('layouts.app')

@section('title', 'To-Do List')

@section('content')
    <header class="page-header">
        <h1 class="page-title">To-Do List</h1>
        <p class="page-subtitle">Plan your day, track your progress, and stay focused.</p>
    </header>

    @include('tasks.partials.counters')

    <section class="card form-card">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-field">
                    <label class="form-label" for="title">New task</label>
                    <input id="title" type="text" name="title" placeholder="Enter task title" value="{{ old('title') }}" maxlength="255" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 5v14"></path>
                        <path d="M5 12h14"></path>
                    </svg>
                    Add Task
                </button>
            </div>
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </form>
    </section>

    @if($tasks->count() > 0)
        <ul class="task-list">
            @foreach($tasks as $task)
                @include('tasks.partials.task-card', ['task' => $task])
            @endforeach
        </ul>
    @else
        <div class="empty-state">
            No tasks yet. Add your first task!
        </div>
    @endif
@endsection
