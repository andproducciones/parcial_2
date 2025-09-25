<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // GET /api/tasks
    public function index()
    {
        return Task::orderByDesc('id')->get();
    }

    // POST /api/tasks
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'completed' => ['sometimes','boolean'],
        ]);

        $task = Task::create($data + ['completed' => $data['completed'] ?? false]);
        return response()->json($task, 201);
    }

    // GET /api/tasks/{task}
    public function show(Task $task)
    {
        return $task;
    }

    // PATCH/PUT /api/tasks/{task}
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => ['sometimes','string','max:255'],
            'completed' => ['sometimes','boolean'],
        ]);

        $task->update($data);
        return $task;
    }

    // DELETE /api/tasks/{task}
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}
