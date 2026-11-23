<?php

namespace Tests\Feature;

use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * Test viewing task list.
     */
    public function test_view_task_list(): void
    {
        $response = $this->get('/tasks');

        $response->assertStatus(200);
    }

    /**
     * Test adding valid tasks.
     */
    public function test_add_valid_task(): void
    {
        $response = $this->post('/tasks', [
            'title' => 'Test Task',
        ]);

        $response->assertRedirect('/tasks');
    }

    /**
     * Test validation rejects empty titles.
     */
    public function test_validation_rejects_empty_titles(): void
    {
        $response = $this->post('/tasks', [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    /**
     * Test validation rejects whitespace-only titles.
     */
    public function test_validation_rejects_whitespace_only_titles(): void
    {
        $response = $this->post('/tasks', [
            'title' => '   ',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    /**
     * Test empty state display.
     */
    public function test_empty_state_display(): void
    {
        $response = $this->get('/tasks');

        $response->assertSee('No tasks yet');
    }

    /**
     * Test toggling task completion.
     */
    public function test_toggle_task_completion(): void
    {
        // First create a task
        $this->post('/tasks', [
            'title' => 'Task to toggle',
        ]);

        // Assuming the task ID is 1
        $response = $this->post('/tasks/1/toggle');

        $response->assertRedirect('/tasks');
    }

    /**
     * Test editing task titles.
     */
    public function test_edit_task_title(): void
    {
        // First create a task
        $this->post('/tasks', [
            'title' => 'Original title',
        ]);

        // Update the task
        $response = $this->put('/tasks/1', [
            'title' => 'Updated title',
        ]);

        $response->assertRedirect('/tasks');
    }

    /**
     * Test deleting tasks.
     */
    public function test_delete_task(): void
    {
        // First create a task
        $this->post('/tasks', [
            'title' => 'Task to delete',
        ]);

        // Delete the task
        $response = $this->delete('/tasks/1');

        $response->assertRedirect('/tasks');
    }

    /**
     * Test completion status persistence.
     */
    public function test_completion_status_persistence(): void
    {
        // First create a task
        $this->post('/tasks', [
            'title' => 'Task for persistence test',
        ]);

        // Toggle to completed
        $this->post('/tasks/1/toggle');

        // Toggle back to pending
        $this->post('/tasks/1/toggle');

        // Toggle to completed again
        $response = $this->post('/tasks/1/toggle');

        $response->assertRedirect('/tasks');
    }
}
