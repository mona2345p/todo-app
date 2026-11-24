@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
    <header class="page-header">
        <h1 class="page-title">Task details</h1>
        <p class="page-subtitle">Review this task and choose your next action.</p>
    </header>

    <section class="card">
        <div class="detail-grid">
            <div class="detail-row">
                <span class="detail-label">Title</span>
                <span class="detail-value">{{ $task->title }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="status-badge {{ $task->completed ? 'status-completed' : 'status-pending' }}">{{ $task->completed ? 'Completed' : 'Pending' }}</span>
            </div>
        </div>
    </section>

    <section class="card" style="margin-top: 24px;">
        <div class="form-row">
            <a class="btn btn-secondary" href="{{ route('tasks.edit', $task->id) }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 20h9"></path>
                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                </svg>
                Edit task
            </a>
            <a class="btn btn-danger" href="{{ route('tasks.delete-confirm', $task->id) }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 6h18"></path>
                    <path d="M8 6V4h8v2"></path>
                    <path d="M19 6l-1 14H6L5 6"></path>
                </svg>
                Delete task
            </a>
            <a class="btn btn-ghost" href="{{ route('tasks.index') }}">Back to tasks</a>
        </div>
    </section>
@endsection
