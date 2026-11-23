# Tasks: Simple To-Do List Application

**Feature**: specs/002-todo-app-mvp/
**Branch**: 002-todo-app-mvp
**Date**: 2026-11-21

## Overview

Implementation tasks for a Laravel-based To-Do List application following MVC architecture with MySQL database and Blade templates. Tasks are organized by user story priority (P1-P4) for independent implementation and testing.

**Total Tasks**: 67 tasks (T001..T067, sequentially numbered)
**Testing**: Mandatory Feature tests per Constitution (GATE 3)
**Git Flow**: Git initialization with repository check
**Laravel Path**: All Laravel paths start with `laravel-app/` (app/, routes/, resources/, tests/, database/)

## Dependencies

### Story Completion Order:
1. **[US1]**: Add New Task (P1) - **BLOCKING** (core functionality)
2. **[US2]**: View Tasks List (P2) - **TECHNICAL DEPENDENCY**: Requires index() method from US1
3. **[US3]**: Toggle Task Status (P3) - **TECHNICAL DEPENDENCY**: Requires Task model with completed field
4. **[US4]**: Edit & Delete Tasks (P4) - **TECHNICAL DEPENDENCY**: Requires CRUD operations from previous stories

### Parallel Execution Opportunities:
- Database setup tasks ([P]) can run alongside frontend setup
- Model creation ([P]) can run with migration creation
- Blade templates ([P]) can be developed concurrently
- Controller methods are largely independent

## Phase 1: Setup (Project Initialization)

### Development Environment
- [x] T001 [P] Start MySQL service from XAMPP (or equivalent MySQL service)
- [x] T002 Create MySQL database `todo_app` via phpMyAdmin or MySQL CLI

### Laravel Project Setup
- [x] T003 [P] Create Laravel project in subdirectory `laravel-app/` using: `composer create-project laravel/laravel laravel-app`
- [x] T004 Configure .env file in `laravel-app/.env` with MySQL settings (update DB_CONNECTION=mysql, DB_DATABASE=todo_app, DB_USERNAME, DB_PASSWORD)
- [x] T005 Generate application key with `php artisan key:generate` from `laravel-app/`

### Git Initialization
- [x] T006 Check if Git repository exists: run `git status`, if command fails with "not a git repository", then run `git init`
- [x] T007 Check current branch: run `git branch --show-current`, if command fails or shows different branch, then create feature branch: `git checkout -b 002-todo-app-mvp`

### Git Commit
- [x] T008 Commit Phase 1 changes: `git add . && git commit -m "feat: Initial setup - Laravel project, MySQL, Git"`

## Phase 2: Foundational Tasks (Blocking Prerequisites)

### Database & Model
- [x] T009 [P] Create Task migration in `laravel-app/database/migrations/[timestamp]_create_tasks_table.php` (from data-model.md: Task entity schema - includes completed field)
- [ ] T010 [P] Create Task model in `laravel-app/app/Models/Task.php` with mass assignable fields (from data-model.md: Task model attributes - includes title and completed)
- [ ] T011 Run migrations to create tasks table (`php artisan migrate` from `laravel-app/`)

### Controller & Routes
- [ ] T012 Create TaskController in `laravel-app/app/Http/Controllers/TaskController.php`
- [ ] T013 Define Task routes in `laravel-app/routes/web.php` (from contracts/ui-contract.md: routes for index, store, toggle, edit, update, destroy)

### Setup Validation
- [ ] T014 Run Laravel setup test: `php artisan --version` from `laravel-app/` and verify `php artisan route:list` shows no task routes yet

### Git Commit
- [ ] T015 Commit Phase 2 changes: `git add . && git commit -m "feat: Implement Phase 2 - Database setup & foundational components"`

## Phase 3: User Story 1 - Add New Task (P1)

**Story Goal**: Enable users to add new tasks with validation (spec FR-001, FR-006)

**Independent Test Criteria**: Can add task with valid title (1-255 chars), validation rejects empty/whitespace-only titles, task appears in list, form clears

**Implementation Tasks**:

### Controller Logic (Foundational for all stories)
- [ ] T016 [US1] Implement `TaskController::index()` method in `laravel-app/app/Http/Controllers/TaskController.php` (from contracts/ui-contract.md: Task List View)
- [ ] T017 [US1] Add `Task::all()` query in `TaskController::index()` (from data-model.md: Task data retrieval)
- [ ] T018 [US1] Pass tasks data to Blade template in `TaskController::index()` (implements FR-002)

### Validation & Create Logic
- [ ] T019 [US1] Create TaskRequest with validation in `laravel-app/app/Http/Requests/TaskRequest.php` (implements FR-001, FR-006, FR-009, FR-010)
- [ ] T020 [US1] Implement `TaskController::store()` method in `laravel-app/app/Http/Controllers/TaskController.php`
- [ ] T021 [US1] Handle validation errors with user-friendly messages in `TaskController::store()` (implements FR-008)

### User Interface
- [ ] T022 [US1] Create task list view in `laravel-app/resources/views/tasks/index.blade.php` (from contracts/ui-contract.md: Task List View)
- [ ] T023 [US1] Add "Add Task" form to index view with CSRF protection in `laravel-app/resources/views/tasks/index.blade.php`
- [ ] T024 [US1] Implement form submission to `TaskController@store` route (from contracts/ui-contract.md: Add New Task workflow)

### Testing (Mandatory per Constitution)
- [ ] T025 [US1] Write feature test for viewing task list in `laravel-app/tests/Feature/TaskTest.php` (validates FR-002)
- [ ] T026 [US1] Write feature test for adding valid tasks in `laravel-app/tests/Feature/TaskTest.php` (validates FR-001)
- [ ] T027 [US1] Write feature test for validation rejection in `laravel-app/tests/Feature/TaskTest.php` (validates FR-006)

### Test Run
- [ ] T028 Run US1 tests from `laravel-app/` with `php artisan test` (should test US1 functionality)

### Git Commit
- [ ] T029 Commit Phase 3 changes: `git add . && git commit -m "feat: Implement US1 - Add new task functionality"`

## Phase 4: User Story 2 - View Tasks List (P2)

**Story Goal**: Display all tasks in a list with clear visual distinction (spec FR-002)

**Independent Test Criteria**: All tasks displayed, empty state shows when no tasks, list loads within 2s (SC-002)

**Implementation Tasks**:

### User Interface Enhancement
- [ ] T030 [US2] Display task list in `laravel-app/resources/views/tasks/index.blade.php` (from contracts/ui-contract.md: Task List display - refines T022)
- [ ] T031 [US2] Implement empty state message in `laravel-app/resources/views/tasks/index.blade.php` (implements FR-002)

### Testing (Mandatory per Constitution)
- [ ] T032 [US2] Write feature test for empty state display in `laravel-app/tests/Feature/TaskTest.php` (validates FR-002 empty state)

### Test Run
- [ ] T033 Run US1 & US2 tests from `laravel-app/` with `php artisan test` (should test US1 & US2 functionality)

### Git Commit
- [ ] T034 Commit Phase 4 changes: `git add . && git commit -m "feat: Implement US2 - View tasks list functionality"`
## Phase 5: User Story 3 - Toggle Task Completion (P3)

**Story Goal**: Allow users to toggle tasks between completed and pending states (spec FR-003)

**Independent Test Criteria**: Checkbox toggles checked/unchecked, visual distinction, status persists, updates within 1s (SC-003)

**Implementation Tasks**:

### Controller Logic
- [ ] T035 [US3] Implement `TaskController::toggle()` method in `laravel-app/app/Http/Controllers/TaskController.php`
- [ ] T036 [US3] Handle status toggle with POST request in `TaskController::toggle()` (from contracts/ui-contract.md: form submission on checkbox)

### User Interface
- [ ] T037 [US3] Add checkbox to each task item in `laravel-app/resources/views/tasks/index.blade.php`
- [ ] T038 [US3] Create form for checkbox submission in `laravel-app/resources/views/tasks/index.blade.php`
- [ ] T039 [US3] Implement CSS styling for completed tasks in `laravel-app/resources/views/tasks/index.blade.php` (from contracts/ui-contract.md: visual distinction)

### Testing (Mandatory per Constitution)
- [ ] T040 [US3] Write feature test for toggling task completion in `laravel-app/tests/Feature/TaskTest.php` (validates FR-003)
- [ ] T041 [US3] Write feature test for completion status persistence in `laravel-app/tests/Feature/TaskTest.php`

### Test Run
- [ ] T042 Run US1-US3 tests from `laravel-app/` with `php artisan test` (should test US1, US2 & US3 functionality)

### Git Commit
- [ ] T043 Commit Phase 5 changes: `git add . && git commit -m "feat: Implement US3 - Toggle task completion functionality"`

## Phase 6: User Story 4 - Edit and Delete Tasks (P4)

**Story Goal**: Enable users to edit task titles and delete tasks permanently (spec FR-004, FR-005, FR-011)

**Independent Test Criteria**: Can edit/delete tasks, error messages for non-existent tasks, operations feedback within 1s (SC-004)

**Implementation Tasks**:

### Edit Functionality
- [ ] T044 [US4] Create edit form template in `laravel-app/resources/views/tasks/edit.blade.php` (from contracts/ui-contract.md: Edit Task Form)
- [ ] T045 [US4] Implement `TaskController::edit()` method in `laravel-app/app/Http/Controllers/TaskController.php`
- [ ] T046 [US4] Implement `TaskController::update()` method in `laravel-app/app/Http/Controllers/TaskController.php`
- [ ] T047 [US4] Add edit button/icon to each task item in `laravel-app/resources/views/tasks/index.blade.php`
- [ ] T048 [US4] Handle "task not found" error in `TaskController::edit()` (implements FR-011)

### Delete Functionality
- [ ] T049 [US4] Implement `TaskController::destroy()` method in `laravel-app/app/Http/Controllers/TaskController.php`
- [ ] T050 [US4] Add delete button/icon to each task item in `laravel-app/resources/views/tasks/index.blade.php`
- [ ] T051 [US4] Create delete form with CSRF protection in `laravel-app/resources/views/tasks/index.blade.php`
- [ ] T052 [US4] Handle "task not found" error in `TaskController::destroy()` (implements FR-011)

### Testing (Mandatory per Constitution)
- [ ] T053 [US4] Write feature test for editing task titles in `laravel-app/tests/Feature/TaskTest.php` (validates FR-004)
- [ ] T054 [US4] Write feature test for deleting tasks in `laravel-app/tests/Feature/TaskTest.php` (validates FR-005)

### Test Run
- [ ] T055 Run all tests from `laravel-app/` with `php artisan test` (should test all US1-US4 functionality)

### Git Commit
- [ ] T056 Commit Phase 6 changes: `git add . && git commit -m "feat: Implement US4 - Edit and delete tasks functionality"`

## Phase 7: Polish & Cross-Cutting Concerns

### Performance Validation
- [ ] T057 Verify task list loads within 2 seconds in browser devtools (validates SC-002)
- [ ] T058 Verify status toggles update within 1 second on page reload (validates SC-003)
- [ ] T059 Verify user operations feedback within 1 second on page reload (validates SC-004)

### Final Validation & Compliance
- [ ] T060 Ensure TaskRequest provides user-friendly validation errors (implements FR-008 and Constitution GATE 5 for validation)
- [ ] T061 Run all quickstart validation scenarios from `specs/002-todo-app-mvp/quickstart.md`
- [ ] T062 Verify all user stories work end-to-end (completes MVP)
- [ ] T063 Ensure code follows PSR-12 standards (Constitution GATE 4)
- [ ] T064 Verify CSRF protection on all forms (Constitution GATE 5)
- [ ] T065 Update documentation if needed

### Final Test Run
- [ ] T066 Run final test suite from `laravel-app/` with `php artisan test` (all tests should pass)

### Git Commit
- [ ] T067 Commit Phase 7 changes: `git add . && git commit -m "feat: Polish & final validation"`

## Implementation Strategy

### MVP Scope (Recommended):
1. **Focus on US1 (Add Task)** first - enables core functionality
2. **Add US2 (View Tasks)** - makes US1 useful
3. **Add US3 (Toggle Status)** - core task management
4. **Add US4 (Edit/Delete)** - complete CRUD operations

### Incremental Delivery:
- Each phase is independently testable
- Can stop after any phase and have working functionality
- Builds complexity gradually

### Notes:
- No authentication required for MVP (single user from spec Assumptions)
- Simple Blade templates with minimal JavaScript (from contracts/ui-contract.md)
- Standard Laravel form submissions (no AJAX required)
- Basic CSS styling acceptable for MVP