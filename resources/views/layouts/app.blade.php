<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'To-Do List')</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f4f7fb;
            --surface: #ffffff;
            --text: #172033;
            --muted: #64748b;
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --success: #0f766e;
            --success-soft: #ecfdf5;
            --danger: #be123c;
            --border: #e2e8f0;
            --shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
            line-height: 1.5;
            color: var(--text);
            background: radial-gradient(circle at top left, #eef2ff 0, var(--bg) 45%);
        }

        a { color: inherit; text-decoration: none; }

        .app-shell {
            width: min(100% - 32px, 960px);
            margin: 0 auto;
            padding: 32px 0 48px;
        }

        .site-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .brand-icon {
            display: grid;
            place-items: center;
            width: 36px;
            height: 36px;
            color: #ffffff;
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            border-radius: 12px;
        }

        .header-note { color: var(--muted); font-size: 0.875rem; }

        .app-main { margin-top: 24px; }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 24px;
        }

        .page-header { margin-bottom: 24px; }

        .page-title {
            margin: 0;
            font-size: clamp(1.75rem, 4vw, 2.25rem);
            letter-spacing: -0.03em;
        }

        .page-subtitle { margin: 6px 0 0; color: var(--muted); }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 40px;
            padding: 9px 16px;
            border: 1px solid transparent;
            border-radius: 11px;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }

        .btn:hover { transform: translateY(-1px); box-shadow: 0 8px 18px rgba(15, 23, 42, 0.12); }
        .btn:focus-visible { outline: 3px solid rgba(79, 70, 229, 0.35); outline-offset: 2px; }
        .btn svg { width: 16px; height: 16px; flex: none; }

        .btn-primary { color: #ffffff; background: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-secondary { color: var(--primary-dark); background: #eef2ff; border-color: #c7d2fe; }
        .btn-danger { color: #ffffff; background: var(--danger); }
        .btn-ghost { color: var(--muted); background: transparent; border-color: var(--border); }
        .btn-ghost:hover { color: var(--text); background: #f8fafc; }

        .form-card { margin-bottom: 24px; }
        .form-row { display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap; }
        .form-field { flex: 1 1 260px; display: grid; gap: 6px; }

        .form-label { font-size: 0.875rem; font-weight: 600; color: var(--muted); }

        input[type="text"] {
            width: 100%;
            min-height: 42px;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 11px;
            font: inherit;
            color: var(--text);
            background: #ffffff;
        }

        input[type="text"]:focus {
            outline: 3px solid rgba(79, 70, 229, 0.18);
            border-color: var(--primary);
        }

        .error { color: var(--danger); font-size: 0.875rem; margin-top: 8px; }

        .counters {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .counter-card {
            padding: 16px 18px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow);
        }

        .counter-label { display: block; color: var(--muted); font-size: 0.875rem; }
        .counter-value { display: block; margin-top: 4px; font-size: 1.75rem; line-height: 1.1; }
        .counter-total .counter-value { color: var(--primary-dark); }
        .counter-pending .counter-value { color: #b45309; }
        .counter-completed .counter-value { color: var(--success); }

        .task-list { display: grid; gap: 14px; list-style: none; margin: 0; padding: 0; }

        .task-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 18px 20px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-left: 4px solid transparent;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .task-card:hover { transform: translateY(-2px); box-shadow: var(--shadow); }
        .task-card.is-complete { border-left-color: var(--success); background: var(--success-soft); }

        .task-card-main { display: flex; align-items: center; gap: 14px; min-width: 0; }
        .task-toggle { width: 20px; height: 20px; accent-color: var(--primary); cursor: pointer; flex: none; }

        .task-title {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .task-card.is-complete .task-title {
            color: var(--muted);
            text-decoration: line-through;
            text-decoration-thickness: 2px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-pending { color: #92400e; background: #fef3c7; }
        .status-completed { color: var(--success); background: #d1fae5; }
        .task-actions { display: flex; flex-wrap: wrap; gap: 8px; justify-content: flex-end; }

        .detail-grid { display: grid; gap: 16px; }
        .detail-row { display: grid; gap: 6px; }
        .detail-label { color: var(--muted); font-size: 0.875rem; font-weight: 600; }
        .detail-value { font-size: 1.125rem; font-weight: 600; overflow-wrap: anywhere; }

        .warning-card { border-left: 4px solid var(--danger); background: #fff1f2; }
        .notice { color: var(--muted); margin: 0 0 16px; }

        .empty-state {
            padding: 48px 24px;
            text-align: center;
            color: var(--muted);
            background: var(--surface);
            border: 1px dashed var(--border);
            border-radius: 16px;
        }

        .app-footer { margin-top: 24px; text-align: center; color: var(--muted); font-size: 0.8125rem; }

        @media (max-width: 640px) {
            .app-shell { width: min(100% - 20px, 960px); padding-top: 16px; }
            .site-header { align-items: flex-start; flex-direction: column; border-radius: 16px; }
            .card { padding: 18px; border-radius: 16px; }
            .counters { grid-template-columns: 1fr; gap: 10px; }
            .task-card { align-items: flex-start; flex-direction: column; gap: 14px; }
            .task-actions { justify-content: flex-start; width: 100%; }
            .task-actions .btn { flex: 1 1 auto; }
            .form-row { align-items: stretch; flex-direction: column; }
            .form-row .btn { width: 100%; }
        }

        @media (prefers-reduced-motion: reduce) {
            .btn, .task-card { transition: none; }
            .btn:hover, .task-card:hover { transform: none; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="app-shell">
        <header class="site-header">
            <a class="brand" href="{{ route('tasks.index') }}">
                <span class="brand-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 11l3 3L22 4"></path>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                </span>
                <span>TaskFlow</span>
            </a>
            <span class="header-note">Simple, focused task management</span>
        </header>

        <main class="app-main">
            @yield('content')
        </main>

        <footer class="app-footer">Built with Laravel and Blade</footer>
    </div>
</body>
</html>
