<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // Display all tasks
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->get();
        return view('tasks', compact('tasks'));
    }

    // Store a new task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task = new Task();
        $task->title = $request->title;
        $task->save();

        return back();
    }

    // Toggle the completed status of a task
    public function toggle(Task $task)
    {
        $task->completed = !$task->completed;
        $task->save();

        return back();
    }
}
