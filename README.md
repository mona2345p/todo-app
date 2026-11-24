# To-Do List

A focused, single-user task manager built with Laravel 13, Blade templates, and MySQL. The interface uses responsive task cards, clear status indicators, live counters, a dedicated details page, and an explicit delete confirmation step.

## Features

- Add, edit, toggle, and permanently delete tasks
- Responsive task cards with Show, Edit, and Delete actions
- Total, pending, and completed counters
- Dedicated task details page
- Explicit delete confirmation with cancel support
- Strikethrough only on completed task titles
- Consistent lightweight CSS styling across all pages
- CSRF protection, escaped output, and validation feedback
- PHPUnit feature tests and Laravel Pint style checks

## Requirements

- PHP 8.3 or newer
- Composer
- MySQL 8+ or MariaDB
- Git
- PHP `pdo_sqlite` extension for isolated SQLite test runs (optional)

## Installation

```bash
git clone <repository-url> todo-app
cd todo-app
composer install
copy .env.example .env
php artisan key:generate
```

Create the development and test databases:

```bash
mysql -u root -p
CREATE DATABASE IF NOT EXISTS todo_app;
CREATE DATABASE IF NOT EXISTS todo_app_test;
```

Configure `.env`:

```text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_app
DB_USERNAME=your_mysql_user
DB_PASSWORD=your_mysql_password
```

Run migrations without resetting development data:

```bash
php artisan migrate
```

## Running the Application

```bash
php artisan serve
```

Open `http://localhost:8000/tasks`.

## Testing

With MySQL available and `todo_app_test` configured:

```bash
php artisan test
```

In environments without MySQL, run the full suite against an isolated in-memory SQLite database:

```powershell
$env:DB_CONNECTION='sqlite'
$env:DB_DATABASE=':memory:'
php -d extension=pdo_sqlite vendor/bin/phpunit
```

Run style checks:

```bash
vendor/bin/pint --test
```

## Project Layout

- `app/Http/Controllers/TaskController.php` — task actions and counter data
- `app/Http/Requests/TaskRequest.php` — title validation
- `app/Models/Task.php` — Eloquent task model
- `resources/views/layouts/app.blade.php` — shared layout and lightweight CSS
- `resources/views/tasks/` — list, details, edit, delete confirmation, and partials
- `routes/web.php` — web routes
- `tests/Feature/TaskTest.php` — feature coverage for all user stories and UI requirements
- `specs/002-todo-app-mvp/` — Spec Kit feature documentation

## Spec Kit Documentation

- `.specify/memory/constitution.md` — project principles and governance
- `specs/002-todo-app-mvp/spec.md` — feature specification
- `specs/002-todo-app-mvp/plan.md` — implementation plan
- `specs/002-todo-app-mvp/data-model.md` — Task entity definition
- `specs/002-todo-app-mvp/contracts/ui-contract.md` — UI contract
- `specs/002-todo-app-mvp/tasks.md` — implementation task checklist
- `specs/002-todo-app-mvp/quickstart.md` — manual validation scenarios
- `.clinerules/workflows/` — Spec Kit workflow definitions

## Notes

- The Laravel application lives at the repository root.
- The application is local-only and single-user; no authentication is included.
- `.env`, dependencies, caches, logs, and local SQLite files are excluded from Git.
