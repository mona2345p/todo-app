# Quickstart Guide: To-Do List Application

**Date**: 2026-11-21  
**Purpose**: Validate end-to-end functionality of the To-Do List application

## Prerequisites

1. **Development Environment**:
   - PHP 8.x installed
   - Composer installed
   - MySQL database server running
   - Laravel development dependencies

2. **Project Setup** (one-time):
   ```bash
   # Clone and navigate to project
   cd /path/to/project
   
   # Install dependencies
   composer install
   
   # Configure environment
   cp .env.example .env
   php artisan key:generate
   
   # Update .env with database credentials
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=todo_app
   # DB_USERNAME=root
   # DB_PASSWORD=yourpassword
   
   # Create database and run migrations
   php artisan migrate
   ```

## Validation Scenarios

### Scenario 1: Application Setup Validation
**Purpose**: Verify Laravel application boots successfully

```bash
# Start development server
php artisan serve

# In browser, navigate to:
# http://localhost:8000

# Expected Result:
# - Laravel welcome page or application homepage loads
# - No PHP errors in console
# - Database connection established
```

### Scenario 2: Add New Task (P1)
**Purpose**: Verify task creation functionality

1. Navigate to application homepage
2. Locate "Add Task" form
3. Enter "Buy groceries" in task input field
4. Click "Add Task" button

**Expected Outcomes**:
- ✅ Task "Buy groceries" appears in task list
- ✅ Input field clears after successful add
- ✅ No JavaScript errors in browser console
- ✅ Validation shows error for empty title submission

### Scenario 3: View Task List (P2)
**Purpose**: Verify task display functionality

1. Add multiple tasks:
   - "Call mom"
   - "Finish report"
   - "Schedule dentist appointment"
2. Refresh page

**Expected Outcomes**:
- ✅ All 3 tasks displayed in list
- ✅ Task titles readable and intact
- ✅ Checkboxes visible for each task
- ✅ No tasks missing from display

### Scenario 4: Toggle Task Completion (P3)
**Purpose**: Verify task status toggle functionality

1. Click checkbox next to "Buy groceries"
2. Observe visual changes
3. Click checkbox again
4. Refresh page to verify persistence

**Expected Outcomes**:
- ✅ Checkbox toggles between checked/unchecked
- ✅ Completed tasks show strikethrough/muted styling
- ✅ Status persists after page refresh
- ✅ Updates happen within 1 second (spec SC-003)

### Scenario 5: Edit Task (P4)
**Purpose**: Verify task editing functionality

1. Find edit button next to "Call mom"
2. Click edit, change title to "Call mom - birthday reminder"
3. Save changes

**Expected Outcomes**:
- ✅ Edit interface appears (modal or inline form)
- ✅ Task title updates correctly in list
- ✅ No duplicate task created
- ✅ Original task ID preserved

### Scenario 6: Delete Task With Confirmation (P4)
**Purpose**: Verify explicit confirmation before permanent deletion

1. Find delete action on the "Finish report" card
2. Confirm the warning page shows the task title
3. Click "Confirm Delete"
4. Refresh the task list

**Expected Outcomes**:
- ✅ Task is not deleted until confirmation
- ✅ Task is removed after confirmation and stays absent after refresh
- ✅ No unintended side effects on other tasks
- ✅ Feedback provided within 1 second (spec SC-004)

### Scenario 7: Cards, Actions, Counters, and Status Styling (US5/US8)
**Purpose**: Verify the enhanced task list interface

1. Add at least three tasks
2. Complete one task with its checkbox
3. Inspect every card and the counters above the list

**Expected Outcomes**:
- ✅ Each task appears in its own card
- ✅ Every card exposes Show, Edit, and Delete actions
- ✅ Total, pending, and completed counters match task state
- ✅ Only the completed task title has strikethrough; action controls never do
- ✅ All four pages share the same visual style

### Scenario 8: Task Details Page (US6)
**Purpose**: Verify the dedicated read-only task view

1. Click Show on a task card
2. Review the displayed title and status
3. Use Edit, Delete, and Back controls

**Expected Outcomes**:
- ✅ Dedicated page shows the correct task title and status
- ✅ Edit opens the edit form for that task
- ✅ Delete opens the confirmation page
- ✅ Back returns to the task list

### Scenario 9: Responsive and Confirmation-Cancel Checks (US5/US7)
**Purpose**: Verify mobile usability and safe cancellation

1. Open the task list at 375px and 1280px widths
2. Start a delete, then click Cancel
3. Return to the list and inspect the task

**Expected Outcomes**:
- ✅ Cards and all actions remain readable and operable at both widths
- ✅ Cancelled confirmation leaves the task and counters unchanged
- ✅ Special characters in titles render as text, including on the confirmation page

## Performance Validation

**Success Criteria Verification**:

| Criteria | Test Method | Target |
|----------|-------------|--------|
| **SC-002**: Task list loads within 2 seconds | Browser devtools Network tab | ≤ 2000ms |
| **SC-003**: Status toggles update within 1 second | Manual timing of checkbox click → visual update | ≤ 1000ms |
| **SC-004**: User operations feedback within 1 second | Manual timing of form submission → feedback | ≤ 1000ms |
| **SC-005**: Invalid inputs rejected properly | Submit empty/whitespace-only titles | Error message shown |
| **SC-006**: Error messages clear and helpful | Read validation error messages | Understandable by user |
| **SC-007**: Every card exposes Show/Edit/Delete | Inspect each task card | 100% of cards |
| **SC-008**: Counters match task state | Compare counters after add/toggle/edit/delete | Exact match |
| **SC-009**: Delete requires confirmation | Confirm and cancel deletion | No premature deletion |
| **SC-010**: Responsive at 375px and 1280px | Resize viewport and use all actions | Readable and operable |
| **SC-011**: Strikethrough only on completed titles | Inspect titles and action controls | 100% / 0% |

## Troubleshooting

**Common Issues & Solutions**:

1. **Database Connection Failed**:
   ```
   SQLSTATE[HY000] [1045] Access denied for user...
   ```
   **Solution**: Verify `.env` database credentials and MySQL service status.

2. **Migration Errors**:
   ```
   SQLSTATE[42S01]: Base table or view already exists...
   ```
   **Solution**: Run `php artisan migrate:fresh` (wipes existing data).

3. **CSRF Token Mismatch**:
   ```
   419 Page Expired
   ```
   **Solution**: Ensure Blade forms include `@csrf` directive.

4. **Validation Errors Not Showing**:
   ```
   No feedback on invalid input
   ```
   **Solution**: Check Blade error display and JavaScript validation.

## Notes

This guide validates **feature functionality** without implementation details. For implementation tasks, refer to `tasks.md` (to be generated by `/speckit-tasks` command).

All scenarios should complete successfully with:
- No PHP errors in console
- No JavaScript errors in browser console
- All validation messages clear and helpful
- Performance within specified targets
