# UI Contract: To-Do List Application

**Date**: 2026-11-21  
**Type**: User Interface Contract  
**Application**: Laravel Blade Web Application (MVP + UI enhancement)

## Overview

This contract defines the user interface requirements for the To-Do List web application. The interface is implemented with Laravel Blade templates using standard HTTP form submissions. No AJAX or frontend framework is required. Styling is lightweight CSS with no new dependencies.

## Interface Components

### 1. Main Layout (`resources/views/layouts/app.blade.php`)
**Purpose**: Base template for all application pages.

**Required Elements**:
- HTML5 doctype and meta tags
- CSRF token meta tag for form security
- Shared lightweight CSS embedded in the layout (no build step or external framework)
- Responsive main container with consistent spacing, typography, buttons, and form controls
- Consistent page header area and main content container
- Page-specific title and content sections

### 2. Task Counters Partial (`resources/views/tasks/partials/counters.blade.php`)
**Purpose**: Show task totals at a glance.

**Required Elements**:
- Total task count
- Pending task count
- Completed task count
- Counts derived from current task state and visible on the task list page

### 3. Task Card Partial (`resources/views/tasks/partials/task-card.blade.php`)
**Purpose**: Render one task consistently wherever a task is shown in the list.

**Required Elements**:
- Separate card container per task
- Clear status indicator for pending or completed
- Task title rendered as safe escaped text
- Show, Edit, and Delete actions for that task
- Completion toggle control with POST form and CSRF token
- Delete action starts the confirmation flow, not immediate deletion
- `completed` styling class applied only to the title of completed tasks; action controls never receive strikethrough

### 4. Task List View (`resources/views/tasks/index.blade.php`)
**Purpose**: Primary page displaying counters and all task cards.

**Required Elements**:
- Page title: "To-Do List"
- Counters partial above the list
- Add Task form with text input, submit button labeled "Add Task", CSRF token, and validation error display
- One task card per task using the task card partial
- Empty state: "No tasks yet. Add your first task!"
- Consistent styling inherited from the shared layout

### 5. Task Details View (`resources/views/tasks/show.blade.php`)
**Purpose**: Dedicated read-only page for a single task.

**Required Elements**:
- Page title indicating task details
- Task title and current status indicator
- Show-backed actions: Edit, Delete, and Back to task list
- Consistent styling inherited from the shared layout

### 6. Edit Task Form (`resources/views/tasks/edit.blade.php`)
**Purpose**: Form for editing an existing task title.

**Required Elements**:
- Pre-filled text input with current task title
- Save button
- Cancel/back link to task list
- CSRF token and validation error display
- Consistent styling inherited from the shared layout

### 7. Delete Confirmation View (`resources/views/tasks/delete.blade.php`)
**Purpose**: Explicit confirmation before permanent deletion.

**Required Elements**:
- Clear statement that the task will be permanently deleted
- Task title displayed for confirmation context
- Confirm Delete control using a DELETE form with CSRF token
- Cancel control returning to the task list without deleting the task
- Consistent styling inherited from the shared layout

## Route Surface

| Method | URI | Name | Purpose |
|--------|-----|------|---------|
| GET | `/` | — | Redirect to task list |
| GET | `/tasks` | `tasks.index` | List tasks with counters and cards |
| POST | `/tasks` | `tasks.store` | Add a task |
| GET | `/tasks/{task}` | `tasks.show` | Task details page |
| GET | `/tasks/{task}/edit` | `tasks.edit` | Edit form |
| PUT/PATCH | `/tasks/{task}` | `tasks.update` | Save edited title |
| GET | `/tasks/{task}/delete-confirm` | `tasks.delete-confirm` | Delete confirmation page |
| DELETE | `/tasks/{task}` | `tasks.destroy` | Permanently delete a task |
| POST | `/tasks/{task}/toggle` | `tasks.toggle` | Toggle completion status |

## User Interactions

### 1. Add New Task (spec US1)
1. User types a task title and clicks "Add Task".
2. System validates input (required, non-whitespace, maximum 255 characters).
3. On success, the list reloads with the new card and updated counters.
4. On error, a validation message is displayed in the form.

### 2. View Tasks and Counters (spec US2, US8)
1. User opens `/tasks`.
2. Counters show total, pending, and completed counts.
3. Each task appears in its own card with status and actions.
4. When no tasks exist, the empty state is shown and all counters are zero.

### 3. View Task Details (spec US6)
1. User clicks Show on a task card.
2. A dedicated details page shows the task title and status.
3. Edit, Delete, and Back controls are available.
4. Back/Return leads to the task list.

### 4. Toggle Task Completion (spec US3)
1. User clicks the checkbox on a task card.
2. Page reloads with the updated status indicator and counters.
3. Completed titles use strikethrough; action controls do not.
4. Status persists on refresh.

### 5. Edit Task Title (spec US4)
1. User clicks Edit on a task card or details page.
2. Edit form displays the current title.
3. User saves a valid title and returns to the list.
4. No duplicate task is created.

### 6. Delete Task Permanently (spec US4, US7)
1. User clicks Delete on a task card or details page.
2. Delete confirmation page shows the task title and warning.
3. Confirming deletes the task permanently and returns to the list with updated counters.
4. Cancelling leaves the task unchanged and returns to the list.

## Validation Rules

### Server-Side Validation (Laravel)
- **Task Title** (FR-001, FR-006): required, not whitespace-only, maximum 255 characters
- User-friendly error messages (FR-008)
- Appropriate errors for non-existent task operations (FR-011)
- Confirmation required before delete (FR-016)

### Client-Side Validation (Basic)
- Optional HTML5 `required` and `maxlength` attributes
- No AJAX required

## Visual Requirements

- Task list uses one card per task (FR-012, SC-007)
- Shared layout provides consistent styling across list, details, edit, and confirmation pages (FR-013)
- Show, Edit, and Delete actions are available on every card (FR-014, SC-007)
- Status indicators clearly distinguish pending and completed tasks (FR-018)
- Strikethrough is applied only to completed task titles, never to action controls (FR-019, SC-011)
- Counters are accurate after every operation (FR-017, SC-008)
- Layout remains readable and operable at 375px and 1280px widths (SC-010)
- CSRF tokens are present on all state-changing forms
- User-provided titles are escaped before display

## Contract Boundaries

This contract defines the minimum viable UI requirements for the MVP and its enhancement. It does not add authentication, categories, due dates, priorities, client-side frameworks, or API endpoints. Styling is limited to lightweight CSS in the shared Blade layout with no new dependencies.

## References

- Feature Specification: `spec.md`
- Data Model: `data-model.md`
- Implementation Plan: `plan.md`
- Success Criteria: SC-002 through SC-011
