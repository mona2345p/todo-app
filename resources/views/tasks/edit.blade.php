@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <header class="page-header">
        <h1 class="page-title">Edit Task</h1>
        <p class="page-subtitle">Update the task title and save your changes.</p>
    </header>

    <section class="card form-card">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-field">
                    <label class="form-label" for="title">Task title</label>
                    <input id="title" type="text" name="title" value="{{ old('title', $task->title) }}" maxlength="255" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 6 9 17l-5-5"></path>
                    </svg>
                    Save
                </button>
                <a class="btn btn-secondary" href="{{ route('tasks.index') }}">Cancel</a>
            </div>
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </form>
    </section>
@endsection
