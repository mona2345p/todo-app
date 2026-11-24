<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     *
     * @return Response
     */
    public function index()
    {
        $tasks = Task::all();
        $total = $tasks->count();
        $completed = $tasks->where('completed', true)->count();
        $pending = $total - $completed;

        return view('tasks.index', compact('tasks', 'total', 'pending', 'completed'));
    }

    /**
     * Display the specified task.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the confirmation page for deleting a task.
     *
     * @param  int  $id
     * @return Response
     */
    public function confirmDelete($id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.delete', compact('task'));
    }

    /**
     * Store a newly created task in storage.
     *
     * @return Response
     */
    public function store(TaskRequest $request)
    {
        Task::create([
            'title' => $request->validated()['title'],
            'completed' => false,
        ]);

        return redirect()->route('tasks.index');
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update([
            'title' => $request->validated()['title'],
        ]);

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index');
    }

    /**
     * Toggle the completion status of a task.
     *
     * @param  int  $id
     * @return Response
     */
    public function toggle($id)
    {
        $task = Task::findOrFail($id);
        $task->update([
            'completed' => ! $task->completed,
        ]);

        return redirect()->route('tasks.index');
    }
}
