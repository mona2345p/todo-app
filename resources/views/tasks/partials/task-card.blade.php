<li class="task-card {{ $task->completed ? 'is-complete' : '' }}" data-task-card="{{ $task->id }}">
    <div class="task-card-main">
        <form action="{{ route('tasks.toggle', $task->id) }}" method="POST" class="task-toggle-form">
            @csrf
            <input
                class="task-toggle"
                type="checkbox"
                {{ $task->completed ? 'checked' : '' }}
                aria-label="Toggle {{ $task->title }}"
                onchange="this.form.submit()"
            >
        </form>

        <div>
            <h3 class="{{ $task->completed ? 'task-title is-complete' : 'task-title' }}">{{ $task->title }}</h3>
            <span class="status-badge {{ $task->completed ? 'status-completed' : 'status-pending' }}">{{ $task->completed ? 'Completed' : 'Pending' }}</span>
        </div>
    </div>

    <div class="task-actions">
        <a class="btn btn-ghost btn-show" href="{{ route('tasks.show', $task->id) }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
            Show
        </a>
        <a class="btn btn-ghost btn-edit" href="{{ route('tasks.edit', $task->id) }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
            </svg>
            Edit
        </a>
        <a class="btn btn-ghost btn-delete" href="{{ route('tasks.delete-confirm', $task->id) }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M3 6h18"></path>
                <path d="M8 6V4h8v2"></path>
                <path d="M19 6l-1 14H6L5 6"></path>
            </svg>
            Delete
        </a>
    </div>
</li>
