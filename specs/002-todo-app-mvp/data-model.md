# Data Model: Simple To-Do List Application

**Date**: 2026-11-21 (Updated)
**Feature**: specs/002-todo-app-mvp/

## Overview

The application manages a single entity: **Task**. Tasks represent individual to-do items
with a title and completion status.

## Entity Definitions

### Task

**Description**: A to-do item representing something that needs to be done.

**Attributes**:
| Attribute | Type | Constraints | Description |
|-----------|------|-------------|-------------|
| id | integer (auto-increment) | Primary key | Unique identifier for the task |
| title | string | 1-255 characters, not empty, not whitespace only | The task description |
| completed | boolean | Default: false | Whether the task is completed (true) or pending (false) |
| created_at | timestamp | Auto-set on creation | When the task was created |
| updated_at | timestamp | Auto-updated on changes | When the task was last updated |

**Validation Rules**:
1. **Title validation** (from spec FR-006):
   - Must not be empty
   - Must not contain only whitespace characters
   - Maximum 255 characters
   - Special characters are allowed (from spec FR-009)

2. **Completed status**: Boolean true/false

**State Transitions**:
- **Pending → Completed**: When user toggles task completion (from spec FR-003)
- **Completed → Pending**: When user toggles task completion (from spec FR-003)

**Business Rules**:
1. Duplicate task titles are allowed (from spec FR-010)
2. Tasks persist between sessions (from spec FR-007)
3. Task operations provide feedback (from spec FR-008)
## Laravel Implementation Details

**Migration Schema**:
```php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('title', 255);
    $table->boolean('completed')->default(false);
    $table->timestamps();
});
```

**Model Class** (`app/Models/Task.php`):
- Uses Laravel Eloquent ORM
- Mass assignable: `['title', 'completed']`
- Casts: `'completed' => 'boolean'`
- Validation rules: `title: 'required|string|min:1|max:255'`

**Validation**:
- Server-side validation via Laravel validation rules
- Client-side validation for immediate feedback (spec FR-008)

**Data Flow**:
1. User input → Controller validation
2. Valid data → Model persistence
3. Database → Eloquent retrieval
4. Task list → Blade template rendering
