<?php

namespace Tests\Feature;

use App\Models\Task;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public function test_root_redirects_to_task_list(): void
    {
        $this->get('/')->assertRedirect('/tasks');
    }

    public function test_view_task_list(): void
    {
        Task::create(['title' => 'Visible task']);

        $this->get('/tasks')
            ->assertOk()
            ->assertSee('Visible task');
    }

    public function test_add_valid_task(): void
    {
        $this->post('/tasks', ['title' => 'Test Task'])
            ->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'completed' => false,
        ]);
    }

    public function test_validation_rejects_empty_titles(): void
    {
        $this->post('/tasks', ['title' => ''])->assertSessionHasErrors(['title']);
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_validation_rejects_whitespace_only_titles(): void
    {
        $this->post('/tasks', ['title' => '   '])->assertSessionHasErrors(['title']);
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_validation_rejects_titles_longer_than_255_characters(): void
    {
        $this->post('/tasks', ['title' => str_repeat('a', 256)])->assertSessionHasErrors(['title']);
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_duplicate_titles_are_allowed(): void
    {
        $this->post('/tasks', ['title' => 'Duplicate']);
        $this->post('/tasks', ['title' => 'Duplicate']);

        $this->assertDatabaseCount('tasks', 2);
    }

    public function test_empty_state_display(): void
    {
        $this->get('/tasks')->assertOk()->assertSee('No tasks yet. Add your first task!');
    }

    public function test_special_characters_are_escaped(): void
    {
        Task::create(['title' => '<script>alert(1)</script>']);

        $this->get('/tasks')
            ->assertSee('&lt;script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_forms_include_csrf_tokens(): void
    {
        $task = Task::create(['title' => 'Token check']);

        $this->get('/tasks')->assertSee('name="_token"', false);
        $this->get("/tasks/{$task->id}/edit")->assertSee('name="_token"', false);
        $this->get("/tasks/{$task->id}/delete-confirm")->assertSee('name="_token"', false);
    }

    public function test_toggle_task_completion(): void
    {
        $task = Task::create(['title' => 'Task to toggle']);

        $this->post("/tasks/{$task->id}/toggle")->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'completed' => true]);
    }

    public function test_completion_status_persistence(): void
    {
        $task = Task::create(['title' => 'Task for persistence test']);

        $this->post("/tasks/{$task->id}/toggle")->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'completed' => true]);

        $this->post("/tasks/{$task->id}/toggle")->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'completed' => false]);

        $this->post("/tasks/{$task->id}/toggle")->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'completed' => true]);
    }

    public function test_edit_task_title(): void
    {
        $task = Task::create(['title' => 'Original title']);

        $this->get("/tasks/{$task->id}/edit")
            ->assertOk()
            ->assertSee('Original title');

        $this->put("/tasks/{$task->id}", ['title' => 'Updated title'])->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated title']);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id, 'title' => 'Original title']);
    }

    public function test_edit_validation_keeps_existing_title(): void
    {
        $task = Task::create(['title' => 'Original title']);

        $this->put("/tasks/{$task->id}", ['title' => ''])->assertSessionHasErrors(['title']);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Original title']);
    }

    public function test_delete_task(): void
    {
        $task = Task::create(['title' => 'Task to delete']);

        $this->delete("/tasks/{$task->id}")->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_missing_tasks_return_not_found(): void
    {
        $this->get('/tasks/999999')->assertNotFound();
        $this->get('/tasks/999999/edit')->assertNotFound();
        $this->get('/tasks/999999/delete-confirm')->assertNotFound();
        $this->put('/tasks/999999', ['title' => 'x'])->assertNotFound();
        $this->delete('/tasks/999999')->assertNotFound();
        $this->post('/tasks/999999/toggle')->assertNotFound();
    }

    public function test_operations_meet_response_time_budgets(): void
    {
        $task = Task::create(['title' => 'Timing task']);

        $start = microtime(true);
        $this->get('/tasks')->assertOk();
        $this->assertLessThan(2, microtime(true) - $start);

        $start = microtime(true);
        $this->post("/tasks/{$task->id}/toggle")->assertRedirect('/tasks');
        $this->assertLessThan(1, microtime(true) - $start);

        $start = microtime(true);
        $this->post('/tasks', ['title' => 'Another task'])->assertRedirect('/tasks');
        $this->assertLessThan(1, microtime(true) - $start);
    }

    public function test_task_list_renders_one_card_with_actions_and_responsive_hooks(): void
    {
        $first = Task::create(['title' => 'First card']);
        $second = Task::create(['title' => 'Second card', 'completed' => true]);

        $response = $this->get('/tasks');
        $response->assertOk();
        $this->assertSharedStyle($response);
        $this->assertTaskCardCount($response->getContent(), 2);

        $response->assertSee('data-task-card="'.$first->id.'"', false)
            ->assertSee('data-task-card="'.$second->id.'"', false)
            ->assertSee(route('tasks.show', $first->id), false)
            ->assertSee(route('tasks.edit', $first->id), false)
            ->assertSee(route('tasks.delete-confirm', $first->id), false)
            ->assertSee('name="viewport"', false)
            ->assertSee('class="task-actions"', false);
    }

    public function test_status_indicators_and_strikethrough_apply_only_to_completed_titles(): void
    {
        Task::create(['title' => 'Pending title']);
        Task::create(['title' => 'Done title', 'completed' => true]);

        $this->get('/tasks')
            ->assertOk()
            ->assertSee('class="task-title is-complete">Done title</h3>', false)
            ->assertDontSee('class="task-title is-complete">Pending title</h3>', false)
            ->assertSee('class="status-badge status-completed">Completed</span>', false)
            ->assertSee('class="status-badge status-pending">Pending</span>', false)
            ->assertSee('class="btn btn-ghost btn-show"', false)
            ->assertSee('class="btn btn-ghost btn-edit"', false)
            ->assertSee('class="btn btn-ghost btn-delete"', false);
    }

    public function test_all_pages_share_consistent_styling(): void
    {
        $task = Task::create(['title' => 'Styled task']);

        foreach ([
            '/tasks',
            "/tasks/{$task->id}",
            "/tasks/{$task->id}/edit",
            "/tasks/{$task->id}/delete-confirm",
        ] as $uri) {
            $this->assertSharedStyle($this->get($uri)->assertOk());
        }
    }

    public function test_counters_are_zero_with_no_tasks(): void
    {
        $this->assertCounters($this->get('/tasks')->assertOk(), 0, 0, 0);
    }

    public function test_counters_match_mixed_statuses(): void
    {
        Task::create(['title' => 'Pending one']);
        Task::create(['title' => 'Pending two']);
        Task::create(['title' => 'Completed one', 'completed' => true]);

        $this->assertCounters($this->get('/tasks')->assertOk(), 3, 2, 1);
    }

    public function test_counters_update_after_add_toggle_edit_and_delete(): void
    {
        $this->assertCounters($this->get('/tasks')->assertOk(), 0, 0, 0);

        $this->post('/tasks', ['title' => 'Counter task'])->assertRedirect('/tasks');
        $this->assertCounters($this->get('/tasks')->assertOk(), 1, 1, 0);

        $task = Task::firstOrFail();
        $this->post("/tasks/{$task->id}/toggle")->assertRedirect('/tasks');
        $this->assertCounters($this->get('/tasks')->assertOk(), 1, 0, 1);

        $this->put("/tasks/{$task->id}", ['title' => 'Renamed counter task'])->assertRedirect('/tasks');
        $this->assertCounters($this->get('/tasks')->assertOk(), 1, 0, 1);

        $this->delete("/tasks/{$task->id}")->assertRedirect('/tasks');
        $this->assertCounters($this->get('/tasks')->assertOk(), 0, 0, 0);
    }

    public function test_task_details_page_shows_title_status_and_actions(): void
    {
        $task = Task::create(['title' => 'Detailed task', 'completed' => true]);

        $this->get('/tasks')
            ->assertOk()
            ->assertSee(route('tasks.show', $task->id), false);

        $response = $this->get("/tasks/{$task->id}");
        $response->assertOk();
        $this->assertSharedStyle($response);

        $response->assertSee('Task details')
            ->assertSee('Detailed task')
            ->assertSee('class="status-badge status-completed">Completed</span>', false)
            ->assertSee(route('tasks.edit', $task->id), false)
            ->assertSee(route('tasks.delete-confirm', $task->id), false)
            ->assertSee(route('tasks.index'), false);
    }

    public function test_task_details_page_escapes_special_characters(): void
    {
        $task = Task::create(['title' => '<script>alert(1)</script>']);

        $this->get("/tasks/{$task->id}")
            ->assertOk()
            ->assertSee('&lt;script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_delete_requires_confirmation_and_cancel_preserves_task(): void
    {
        $task = Task::create(['title' => 'Confirm me']);

        $this->get('/tasks')
            ->assertOk()
            ->assertSee(route('tasks.delete-confirm', $task->id), false)
            ->assertDontSee('action="'.route('tasks.destroy', $task->id).'"', false);

        $response = $this->get("/tasks/{$task->id}/delete-confirm");
        $response->assertOk();
        $this->assertSharedStyle($response);

        $response->assertSee('permanently deleted')
            ->assertSee('Confirm Delete')
            ->assertSee(route('tasks.destroy', $task->id), false)
            ->assertSee(route('tasks.index'), false);

        $this->get(route('tasks.index'))->assertOk();
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Confirm me']);
    }

    public function test_confirmed_deletion_removes_task_and_updates_counters(): void
    {
        Task::create(['title' => 'Keep me']);
        $task = Task::create(['title' => 'Delete me']);

        $this->get("/tasks/{$task->id}/delete-confirm")->assertOk();
        $this->delete("/tasks/{$task->id}")->assertRedirect('/tasks');

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $this->assertCounters($this->get('/tasks')->assertOk(), 1, 1, 0);
    }

    public function test_delete_confirmation_escapes_task_title(): void
    {
        $task = Task::create(['title' => '<script>alert(1)</script>']);

        $this->get("/tasks/{$task->id}/delete-confirm")
            ->assertOk()
            ->assertSee('&lt;script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    private function assertSharedStyle($response): void
    {
        $response->assertSee('class="app-shell"', false)
            ->assertSee('class="site-header"', false)
            ->assertSee('class="btn', false);
    }

    private function assertCounters($response, int $total, int $pending, int $completed): void
    {
        $response->assertSee('data-counter="total">'.$total.'</strong>', false)
            ->assertSee('data-counter="pending">'.$pending.'</strong>', false)
            ->assertSee('data-counter="completed">'.$completed.'</strong>', false);
    }

    private function assertTaskCardCount(string $content, int $expected): void
    {
        $this->assertSame($expected, substr_count($content, '<li class="task-card'));
    }
}
