# Implementation Plan: Simple To-Do List Application

**Branch**: `002-todo-app-mvp` | **Date**: 2026-11-21 | **Spec**: specs/002-todo-app-mvp/spec.md

**Input**: Feature specification from `/specs/002-todo-app-mvp/spec.md`, including UI enhancement stories US5–US8 and requirements FR-012–FR-020.

## Summary

Enhance the existing single-project Laravel To-Do List application at the repository root. Preserve the current MySQL persistence, Blade MVC structure, add/view/edit/delete/toggle behavior, validation rules, and test setup. Add a modern, professional, responsive UI with one card per task, Show/Edit/Delete actions on every card, a dedicated task details page, explicit delete confirmation, total/pending/completed counters, clear status indicators, and consistent styling across all pages. Styling remains lightweight CSS with no new frontend dependencies or asset pipeline.

## Technical Context

**Language/Version**: PHP 8.3+ / Laravel 13.x (installed 13.43.0)

**Primary Dependencies**: Laravel Framework, MySQL, Blade templates (from Constitution)

**Storage**: MySQL database (from Constitution); development data must be preserved

**Testing**: PHPUnit + Laravel feature tests; isolated test database (from Constitution)

**Target Platform**: Web application - local development only (from spec Assumptions)

**Project Type**: Laravel MVC Web Application (single repository-root application)

**Performance Goals**:
- Task list loads within 2 seconds for up to 100 tasks (SC-002)
- Status toggles update within 1 second (SC-003)
- User operations provide feedback within 1 second (SC-004)
- Cards and actions remain usable at 375px and 1280px widths (SC-010)

**Constraints**:
- Local development environment only
- Single user application (no authentication required)
- Maximum 255 characters for task titles
- UI rendered with Blade templates and lightweight CSS in the shared layout
- No JavaScript framework, CSS framework, asset pipeline, or new Composer/npm dependencies
- Delete is permanent only after explicit confirmation
- Counters and status indicators derive from persisted task state

**Scale/Scope**:
- Up to 100 tasks (SC-002)
- Pages: task list, task details, task edit, delete confirmation
- Simple CRUD and status operations for the Task entity, unchanged from MVP

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-checked after Phase 1 design.*

### Gates (from Constitution):
✅ **GATE 1 - Laravel Framework**: Plan uses the existing Laravel application at the repository root
✅ **GATE 2 - MVC Structure**: Plan follows Laravel MVC with controllers, requests, models, and views
✅ **GATE 3 - Unit & Feature Tests**: Plan extends Laravel feature tests for all acceptance scenarios
✅ **GATE 4 - Code Style (PSR-12)**: Plan keeps PHP changes PSR-12 compliant
✅ **GATE 5 - Security Protection**: CSRF tokens, escaped output, and confirmation steps are retained
✅ **GATE 6 - MySQL Database**: Plan uses the existing MySQL configuration and preserves records
✅ **GATE 7 - Blade Templates**: Plan uses Blade layouts, views, and partials
✅ **GATE 8 - Local Development**: Plan remains local-only and single-user

**STATUS**: ✅ ALL GATES PASS

**Re-check after UI design**: The enhancement introduces no new dependency, no external interface, and no authentication. All gates still pass with no constitution violations.

## Project Structure

### Documentation (this feature)

```text
specs/002-todo-app-mvp/
├── plan.md              # This file
├── research.md          # Existing decisions
├── data-model.md        # Existing Task entity definition
├── quickstart.md        # Validation guide
├── contracts/           # UI contract
│   └── ui-contract.md
└── tasks.md             # Phase 2 output (/speckit-tasks, not generated here)
```

### Source Code Structure

**Selected Structure**: Laravel MVC Web Application (single project at repository root)

```text
todo-app/
├── app/
│   ├── Models/
│   │   └── Task.php
│   └── Http/
│       ├── Controllers/
│       │   └── TaskController.php
│       ├── Requests/
│       │   └── TaskRequest.php
│       └── Middleware/
│
├── config/
├── database/
│   ├── migrations/
│   │   └── [timestamp]_create_tasks_table.php
│   └── database.sqlite                 # Existing local artifact, unchanged
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php           # Shared layout + lightweight CSS
│       └── tasks/
│           ├── index.blade.php         # List + counters + cards
│           ├── show.blade.php          # Dedicated task details page
│           ├── edit.blade.php          # Edit form
│           ├── delete.blade.php        # Delete confirmation page
│           └── partials/
│               ├── counters.blade.php  # Total/pending/completed counters
│               └── task-card.blade.php # Single task card with actions
│
├── routes/
│   └── web.php
│
├── tests/
│   ├── Feature/
│   │   └── TaskTest.php
│   └── Unit/
│
├── public/
│   └── index.php
├── storage/
└── vendor/
```

**Structure Justification**:
- **Laravel MVC**: Mandated by Constitution (GATE 2)
- **Single Project**: Preserves the consolidated repository-root application
- **Blade Layout and Partials**: Provides consistent styling across pages without new dependencies
- **MySQL Database**: Preserves existing data and configuration (GATE 6)
- **Testing Structure**: PHPUnit + Laravel feature tests (GATE 3)

## Design Approach

- The shared `layouts/app.blade.php` owns the HTML shell, CSRF meta tag, and lightweight responsive CSS so every page looks consistent.
- The task list renders counters from the task collection and one task card partial per task.
- Each card shows a status indicator, the task title, and Show, Edit, and Delete actions.
- Only completed task titles receive the `completed` styling class; action controls never inherit strikethrough.
- The details view is a dedicated read-only page using the same layout.
- Delete uses a dedicated confirmation view with explicit confirm and cancel controls; cancel leaves the task unchanged.
- Counters are computed server-side from persisted state and refreshed on every page reload.
- Existing validation, CSRF protection, escaped output, routes for CRUD/toggle, and MySQL persistence remain unchanged.

## Test Strategy

- Extend `tests/Feature/TaskTest.php` with scenarios for card rendering, actions on every card, details page, delete confirmation/cancel, counters, status indicators, and responsive-facing markup.
- Keep tests isolated from development data.
- Verify PSR-12 with Pint and confirm CSRF tokens and escaped task titles remain present in rendered pages.

## Complexity Tracking

No constitution violations; no complexity exceptions required.
