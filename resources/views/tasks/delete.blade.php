@extends('layouts.app')

@section('title', 'Confirm Delete')

@section('content')
    <header class="page-header">
        <h1 class="page-title">Confirm delete</h1>
        <p class="page-subtitle">Please review this action before continuing.</p>
    </header>

    <section class="card warning-card">
        <p class="notice"><strong>This task will be permanently deleted.</strong> This action cannot be undone.</p>

        <div class="detail-grid">
            <div class="detail-row">
                <span class="detail-label">Task</span>
                <span class="detail-value">{{ $task->title }}</span>
            </div>
        </div>
    </section>

    <section class="card" style="margin-top: 24px;">
        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="form-row">
                <button type="submit" class="btn btn-danger">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 6h18"></path>
                        <path d="M8 6V4h8v2"></path>
                        <path d="M19 6l-1 14H6L5 6"></path>
                    </svg>
                    Confirm Delete
                </button>
                <a class="btn btn-secondary" href="{{ route('tasks.index') }}">Cancel</a>
            </div>
        </form>
    </section>
@endsection
