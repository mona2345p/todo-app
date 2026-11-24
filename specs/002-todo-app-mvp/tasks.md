# Tasks: Simple To-Do List Application

**Feature**: specs/002-todo-app-mvp/
**Branch**: 002-todo-app-mvp
**Date**: 2026-11-21

## Overview

Implementation tasks for a Laravel-based To-Do List application following MVC architecture with MySQL database and Blade templates. Tasks are organized by user story priority (P1-P4) for independent implementation and testing.

**Total Tasks**: 101 tasks (T001..T101, sequentially numbered)
**Testing**: Mandatory Feature tests per Constitution (GATE 3)
**Git Flow**: Git initialization with repository check
**Laravel Path**: Laravel application lives at the repository root (app/, routes/, resources/, tests/, database/)

## Dependencies

### Story Completion Order:
1. **[US1]**: Add New Task (P1) - **BLOCKING** (core functionality)
2. **[US2]**: View Tasks List (P2) - **TECHNICAL DEPENDENCY**: Requires index() method from US1
3. **[US3]**: Toggle Task Status (P3) - **TECHNICAL DEPENDENCY**: Requires Task model with completed field
4. **[US4]**: Edit & Delete Tasks (P4) - **TECHNICAL DEPENDENCY**: Requires CRUD operations from previous stories
5. **[US5]**: Modern Responsive Task Cards (P2 enhancement) - **TECHNICAL DEPENDENCY**: Requires US2 list view (T031) and existing completed styling (T039)
6. **[US8]**: Task Status Counters (P3) - **TECHNICAL DEPENDENCY**: Requires US3 toggle status (T039) and US5 cards (T071)
7. **[US6]**: Dedicated Task Details Page (P4) - **TECHNICAL DEPENDENCY**: Requires US5 cards (T071) and US8 counters (T077)
8. **[US7]**: Delete Confirmation (P4) - **TECHNICAL DEPENDENCY**: Requires US4 delete behavior (T055-T056) and US6 details page (T083-T084)

### Parallel Execution Opportunities:
- Database setup tasks ([P]) can run alongside frontend setup
- Model creation ([P]) can run with migration creation
- Blade templates ([P]) can be developed concurrently
- Controller methods are largely independent
- New test-writing and shared-layout tasks ([P]) (T068, T069, T074, T080, T087, T095) can run in parallel before integration
- New view partials ([P]) (T070, T075) can be authored in parallel after T069 defines shared CSS hooks

## Phase 1: Setup (Project Initialization)

### Development Environment
- [x] T001 [P] Start MySQL service from XAMPP (or equivalent MySQL service)
- [x] T002 Create MySQL database `todo_app` via phpMyAdmin or MySQL CLI

### Laravel Project Setup
- [x] T003 [P] Create Laravel project at repository root using: `composer create-project laravel/laravel .`
- [x] T004 Configure .env file in `.env` with MySQL settings (update DB_CONNECTION=mysql, DB_DATABASE=todo_app, DB_USERNAME, DB_PASSWORD)
- [x] T005 Generate application key with `php artisan key:generate` from the repository root

### Git Initialization
- [x] T006 Check if Git repository exists: run `git status`, if command fails with "not a git repository", then run `git init`
- [x] T007 Check current branch: run `git branch --show-current`, if command fails or shows different branch, then create feature branch: `git checkout -b 002-todo-app-mvp`

### Git Commit
- [x] T008 Commit Phase 1 changes: `git add . && git commit -m "feat: Initial setup - Laravel project, MySQL, Git"`

## Phase 2: Foundational Tasks (Blocking Prerequisites)

### Database & Model
- [x] T009 [P] Create Task migration in `database/migrations/[timestamp]_create_tasks_table.php` (from data-model.md: Task entity schema - includes completed field)
- [x] T010 [P] Create Task model in `app/Models/Task.php` with mass assignable fields (from data-model.md: Task model attributes - includes title and completed)
- [x] T011 Run migrations to create tasks table (`php artisan migrate` from the repository root)

### Controller & Routes
- [x] T012 Create TaskController in `app/Http/Controllers/TaskController.php`
- [x] T013 Define Task routes in `routes/web.php` (from contracts/ui-contract.md: routes for index, store, toggle, edit, update, destroy)

### Setup Validation
- [x] T014 Run Laravel setup test: `php artisan --version` from the repository root and verify `php artisan route:list` shows the registered task routes

### Git Commit
- [x] T015 Commit Phase 2 changes: `git add . && git commit -m "feat: Implement Phase 2 - Database setup & foundational components"`

## Phase 3: User Story 1 - Add New Task (P1)

**Story Goal**: Enable users to add new tasks with validation (spec FR-001, FR-006)

**Independent Test Criteria**: Can add task with valid title (1-255 chars), validation rejects empty/whitespace-only titles, task appears in list, form clears

**Implementation Tasks**:

### Controller Logic (Foundational for all stories)
- [x] T016 [US1] Implement `TaskController::index()` method in `app/Http/Controllers/TaskController.php` (from contracts/ui-contract.md: Task List View)
- [x] T017 [US1] Add `Task::all()` query in `TaskController::index()` (from data-model.md: Task data retrieval)
- [x] T018 [US1] Pass tasks data to Blade template in `TaskController::index()` (implements FR-002)

### Validation & Create Logic
- [x] T019 [US1] Create TaskRequest with validation in `app/Http/Requests/TaskRequest.php` (implements FR-001, FR-006, FR-009, FR-010)
- [x] T020 [US1] Implement `TaskController::store()` method in `app/Http/Controllers/TaskController.php`
- [x] T021 [US1] Handle validation errors with user-friendly messages in `TaskController::store()` (implements FR-008)

### User Interface
- [x] T022 [US1] Create task list view in `resources/views/tasks/index.blade.php` (from contracts/ui-contract.md: Task List View)
- [x] T023 [US1] Add "Add Task" form to index view with CSRF protection in `resources/views/tasks/index.blade.php`
- [x] T024 [US1] Implement form submission to `TaskController@store` route (from contracts/ui-contract.md: Add New Task workflow)

### Testing (Mandatory per Constitution)
- [x] T025 [US1] Write feature test for viewing task list in `tests/Feature/TaskTest.php` (validates FR-002)
- [x] T026 [US1] Write feature test for adding valid tasks in `tests/Feature/TaskTest.php` (validates FR-001)
- [x] T027 [US1] Write feature test for validation rejection in `tests/Feature/TaskTest.php` (validates FR-006)

### Test Run
- [x] T028 Run US1 tests from the repository root with the isolated test database command in SETUP_GUIDE.md (should test US1 functionality)

### Git Commit
- [x] T029 Commit Phase 3 changes: `git add . && git commit -m "feat: Implement US1 - Add new task functionality"`

## Phase 4: User Story 2 - View Tasks List (P2)

**Story Goal**: Display all tasks in a list with clear visual distinction (spec FR-002)

**Independent Test Criteria**: All tasks displayed, empty state shows when no tasks, list loads within 2s (SC-002)

**Implementation Tasks**:

### User Interface Enhancement
- [x] T030 [US2] Display task list in `resources/views/tasks/index.blade.php` (from contracts/ui-contract.md: Task List display - refines T022)
- [x] T031 [US2] Implement empty state message in `resources/views/tasks/index.blade.php` (implements FR-002)

### Testing (Mandatory per Constitution)
- [x] T032 [US2] Write feature test for empty state display in `tests/Feature/TaskTest.php` (validates FR-002 empty state)

### Test Run
- [x] T033 Run US1 & US2 tests from the repository root with the isolated test database command in SETUP_GUIDE.md (should test US1 & US2 functionality)

### Git Commit
- [x] T034 Commit Phase 4 changes: `git add . && git commit -m "feat: Implement US2 - View tasks list functionality"`
## Phase 5: User Story 3 - Toggle Task Completion (P3)

**Story Goal**: Allow users to toggle tasks between completed and pending states (spec FR-003)

**Independent Test Criteria**: Checkbox toggles checked/unchecked, visual distinction, status persists, updates within 1s (SC-003)

**Implementation Tasks**:

### Controller Logic
- [x] T035 [US3] Implement `TaskController::toggle()` method in `app/Http/Controllers/TaskController.php`
- [x] T036 [US3] Handle status toggle with POST request in `TaskController::toggle()` (from contracts/ui-contract.md: form submission on checkbox)

### User Interface
- [x] T037 [US3] Add checkbox to each task item in `resources/views/tasks/index.blade.php`
- [x] T038 [US3] Create form for checkbox submission in `resources/views/tasks/index.blade.php`
- [x] T039 [US3] Implement CSS styling for completed tasks in `resources/views/tasks/index.blade.php` (from contracts/ui-contract.md: visual distinction)

### Testing (Mandatory per Constitution)
- [x] T040 [US3] Write feature test for toggling task completion in `tests/Feature/TaskTest.php` (validates FR-003)
- [x] T041 [US3] Write feature test for completion status persistence in `tests/Feature/TaskTest.php`

### Test Run
- [x] T042 Run US1-US3 tests from the repository root with the isolated test database command in SETUP_GUIDE.md (should test US1, US2 & US3 functionality)

### Git Commit
- [x] T043 Commit Phase 5 changes: `git add . && git commit -m "feat: Implement US3 - Toggle task completion functionality"`

## Phase 6: User Story 4 - Edit and Delete Tasks (P4)

**Story Goal**: Enable users to edit task titles and delete tasks permanently (spec FR-004, FR-005, FR-011)

**Independent Test Criteria**: Can edit/delete tasks, error messages for non-existent tasks, operations feedback within 1s (SC-004)

**Implementation Tasks**:

### Edit Functionality
- [x] T044 [US4] Create edit form template in `resources/views/tasks/edit.blade.php` (from contracts/ui-contract.md: Edit Task Form)
- [x] T045 [US4] Implement `TaskController::edit()` method in `app/Http/Controllers/TaskController.php`
- [x] T046 [US4] Implement `TaskController::update()` method in `app/Http/Controllers/TaskController.php`
- [x] T047 [US4] Add edit button/icon to each task item in `resources/views/tasks/index.blade.php`
- [x] T048 [US4] Handle "task not found" error in `TaskController::edit()` (implements FR-011)

### Delete Functionality
- [x] T049 [US4] Implement `TaskController::destroy()` method in `app/Http/Controllers/TaskController.php`
- [x] T050 [US4] Add delete button/icon to each task item in `resources/views/tasks/index.blade.php`
- [x] T051 [US4] Create delete form with CSRF protection in `resources/views/tasks/index.blade.php`
- [x] T052 [US4] Handle "task not found" error in `TaskController::destroy()` (implements FR-011)

### Testing (Mandatory per Constitution)
- [x] T053 [US4] Write feature test for editing task titles in `tests/Feature/TaskTest.php` (validates FR-004)
- [x] T054 [US4] Write feature test for deleting tasks in `tests/Feature/TaskTest.php` (validates FR-005)

### Test Run
- [x] T055 Run all tests from the repository root with the isolated test database command in SETUP_GUIDE.md (should test all US1-US4 functionality)

### Git Commit
- [x] T056 Commit Phase 6 changes: `git add . && git commit -m "feat: Implement US4 - Edit and delete tasks functionality"`

## Phase 7: Polish & Cross-Cutting Concerns

### Performance Validation
- [x] T057 Verify task list loads within 2 seconds in browser devtools (validates SC-002)
- [x] T058 Verify status toggles update within 1 second on page reload (validates SC-003)
- [x] T059 Verify user operations feedback within 1 second on page reload (validates SC-004)

### Final Validation & Compliance
- [x] T060 Ensure TaskRequest provides user-friendly validation errors (implements FR-008 and Constitution GATE 5 for validation)
- [x] T061 Run all quickstart validation scenarios from `specs/002-todo-app-mvp/quickstart.md`
- [x] T062 Verify all user stories work end-to-end (completes MVP)
- [x] T063 Ensure code follows PSR-12 standards (Constitution GATE 4)
- [x] T064 Verify CSRF protection on all forms (Constitution GATE 5)
- [x] T065 Update documentation if needed

### Final Test Run
- [x] T066 Run final test suite from the repository root with the isolated test database command in SETUP_GUIDE.md (all tests should pass)

### Git Commit
- [x] T067 Commit Phase 7 changes: `git add . && git commit -m "feat: Polish & final validation"`

## Phase 8: US5 - Modern Responsive Task Cards (P2 Enhancement)

**Goal**: Present every task as a separate, consistently styled card with Show/Edit/Delete actions and clear status.

**Independent Test Criteria**: Task list renders one card per task with Show, Edit, Delete, status indicator, and working responsive layout at 375px and 1280px.

**Depends on**: T031 (`resources/views/tasks/index.blade.php`) and T039 (existing completed styling); no change to US1-US4 behavior.

- [x] T068 [P] [US5] Write feature tests in `tests/Feature/TaskTest.php` verifying one card per task, Show/Edit/Delete controls on every card, shared layout usage, consistent styling across list, details, edit, and delete confirmation pages, and responsive markup hooks (FR-012, FR-013, FR-014, SC-007, SC-010)
- [x] T069 [P] [US5] Add shared responsive CSS and consistent page shell in `resources/views/layouts/app.blade.php` using lightweight CSS only, with no new frontend dependencies (FR-013, FR-020, SC-010)
- [x] T070 [US5] Create `resources/views/tasks/partials/task-card.blade.php` with escaped title, status indicator, toggle POST form with CSRF, and Show/Edit/Delete actions; apply strikethrough only to completed titles (FR-014, FR-018, FR-019, SC-011)
- [x] T071 [US5] Render `resources/views/tasks/partials/task-card.blade.php` for every task in `resources/views/tasks/index.blade.php` through the shared layout (FR-012)
- [x] T072 [US5] Run US5 tests from the repository root with the isolated test database command in `SETUP_GUIDE.md` and confirm T001-T067 behavior remains unchanged
- [x] T073 [US5] Commit Phase 8 changes: `git add . && git commit -m "feat: Implement US5 - responsive task cards"`

## Phase 9: US8 - Task Status Counters (P3)

**Goal**: Show accurate total, pending, and completed counts on the task list.

**Independent Test Criteria**: Counters are zero for an empty list and update correctly after add, toggle, edit, and delete operations.

**Depends on**: T039 (toggle status), T068-T072 (US5 cards), and existing MySQL persistence.

- [x] T074 [P] [US8] Write feature tests in `tests/Feature/TaskTest.php` for zero counts, mixed pending/completed counts, and counter updates after add, toggle, edit, and delete (FR-017, SC-008)
- [x] T075 [P] [US8] Create `resources/views/tasks/partials/counters.blade.php` rendering total, pending, and completed counts from passed variables (FR-017)
- [x] T076 [US8] Compute and pass `total`, `pending`, and `completed` counts from `TaskController::index()` in `app/Http/Controllers/TaskController.php` (FR-017, SC-008)
- [x] T077 [US8] Render `resources/views/tasks/partials/counters.blade.php` in `resources/views/tasks/index.blade.php` above the task cards (FR-017)
- [x] T078 [US8] Run US5-US8 tests from the repository root with the isolated test database command in `SETUP_GUIDE.md`
- [x] T079 [US8] Commit Phase 9 changes: `git add . && git commit -m "feat: Implement US8 - task status counters"`

## Phase 10: US6 - Dedicated Task Details Page (P4)

**Goal**: Provide a dedicated page to view a single task's title and status with Edit, Delete, and Back controls.

**Independent Test Criteria**: Clicking Show opens the correct task details page; Edit, Delete, and Back controls work; unknown IDs return an error without breaking the list.

**Depends on**: T071 (task cards), T077 (counters), and T055-T056 (existing edit/delete behavior).

- [x] T080 [P] [US6] Write feature tests in `tests/Feature/TaskTest.php` for the details page title/status, Show action from a card, Edit/Delete/Back controls, and missing-task handling (FR-015)
- [x] T081 [US6] Add the `tasks.show` GET route for `/tasks/{task}` in `routes/web.php` per `specs/002-todo-app-mvp/contracts/ui-contract.md`
- [x] T082 [US6] Implement `TaskController::show()` in `app/Http/Controllers/TaskController.php` using `findOrFail` and passing the task to the details view (FR-015)
- [x] T083 [US6] Create `resources/views/tasks/show.blade.php` with escaped title, status indicator, Edit, Delete, and Back-to-list controls in the shared layout (FR-013, FR-015, FR-018)
- [x] T084 [US6] Add the Show action link in `resources/views/tasks/partials/task-card.blade.php` targeting `tasks.show` (FR-014)
- [x] T085 [US6] Run US5-US8 tests from the repository root with the isolated test database command in `SETUP_GUIDE.md`
- [x] T086 [US6] Commit Phase 10 changes: `git add . && git commit -m "feat: Implement US6 - task details page"`

## Phase 11: US7 - Delete Confirmation (P4)

**Goal**: Require explicit confirmation before permanent deletion and preserve the task when cancelled.

**Independent Test Criteria**: Delete opens a confirmation page showing the task title; confirm deletes and updates counters; cancel leaves the task unchanged.

**Depends on**: T055-T056 (existing delete flow), T083-T084 (details page and Show action), and T077 (counters).

- [x] T087 [P] [US7] Write feature tests in `tests/Feature/TaskTest.php` for confirmation page rendering, confirm-delete redirect, counter updates after deletion, and cancel preserving the task (FR-016, SC-009)
- [x] T088 [US7] Add the `tasks.delete-confirm` GET route for `/tasks/{task}/delete-confirm` in `routes/web.php` per `specs/002-todo-app-mvp/contracts/ui-contract.md`
- [x] T089 [US7] Implement `TaskController::confirmDelete()` in `app/Http/Controllers/TaskController.php` passing the task to the confirmation view (FR-016)
- [x] T090 [US7] Create `resources/views/tasks/delete.blade.php` with permanent-deletion warning, escaped task title, DELETE confirm form with CSRF, and Cancel link (FR-016, Constitution GATE 5)
- [x] T091 [US7] Update Delete actions in `resources/views/tasks/partials/task-card.blade.php` and `resources/views/tasks/show.blade.php` to target `tasks.delete-confirm` instead of deleting immediately (FR-014, FR-016)
- [x] T092 [US7] Update `TaskController::destroy()` in `app/Http/Controllers/TaskController.php` to redirect to `tasks.index` after confirmed deletion so counters refresh (preserves existing behavior)
- [x] T093 [US7] Run US5-US8 tests from the repository root with the isolated test database command in `SETUP_GUIDE.md`
- [x] T094 [US7] Commit Phase 11 changes: `git add . && git commit -m "feat: Implement US7 - delete confirmation"`

## Phase 12: UI Regression & Cross-Cutting Validation

**Goal**: Confirm all MVP and enhanced UI requirements pass together without regressions.

**Independent Test Criteria**: Full feature suite passes; responsive layout, status styling, counters, confirmation flow, CSRF, and escaping satisfy SC-007 through SC-011.

**Depends on**: T068-T094 (all new UI stories) and T001-T067 (existing MVP).

- [x] T095 [P] Add regression tests in `tests/Feature/TaskTest.php` proving US1-US4 still pass alongside US5-US8, SC-007 through SC-011 assertions are present, all four pages share consistent styling, and delete confirmation escapes the task title
- [x] T096 Verify responsive behavior at 375px and 1280px using `resources/views/layouts/app.blade.php`, `resources/views/tasks/partials/task-card.blade.php`, and `resources/views/tasks/index.blade.php` (SC-010)
- [x] T097 Verify strikethrough applies only to completed titles in `resources/views/tasks/partials/task-card.blade.php` and never to Show/Edit/Delete controls (FR-019, SC-011)
- [x] T098 Verify CSRF tokens on new forms in `resources/views/tasks/partials/task-card.blade.php` and `resources/views/tasks/delete.blade.php`, and verify escaped task-title output on the delete confirmation page for XSS protection (Constitution GATE 5)
- [x] T099 Update `specs/002-todo-app-mvp/quickstart.md` with validation steps for cards, counters, details page, delete confirmation, and responsive checks
- [x] T100 Run the full test suite from the repository root with the isolated test database command in `SETUP_GUIDE.md`; all tests must pass
- [x] T101 Commit Phase 12 changes: `git add . && git commit -m "chore: UI regression validation and documentation"`

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
- Enhanced UI phases preserve Laravel/Blade/MySQL and add responsive cards, counters, details, and delete confirmation with lightweight CSS only
## Final Implementation Verification

- All functional requirements implemented.
- MySQL migration verified successfully.
- Automated tests: 28 passed, 173 assertions.
- Fresh installation from GitHub verified.
- GitHub publication completed successfully.

### Commit Verification

- T015: 95f84fb
- T029: 2f01a94
- T043: cc8bb4d
- T067: 2564bb3

The changes for T034, T056, T073, T079, T086,
T094, and T101 were saved in consolidated commit
c7f0246 instead of separate phase commits.

### Fresh Installation Fixes

- 6e81e43: Required Laravel directories.
- 28f7fd6: Required test directory.
