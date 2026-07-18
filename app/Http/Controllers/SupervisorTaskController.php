<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisorTaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request)
    {
        // 1. Identify the logged-in supervisor (with safe fallback)
        $supervisor = Supervisor::where('email', Auth::user()->email ?? '')->first();
        if (!$supervisor) {
            $supervisor = Supervisor::first();
        }
        $supervisorId = $supervisor ? $supervisor->id : 0;

        // 2. Fetch Tasks assigned to this supervisor's interns
        $query = Task::whereHas('intern', function($q) use ($supervisorId) {
            $q->where('supervisor_id', $supervisorId);
        })->with('intern'); // Eager load the intern relationship

        // 3. Optional Search Functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('priority', 'like', "%{$search}%")
                  ->orWhereHas('intern', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Fix: Changed 'due_date' back to 'deadline' kyunki database mein due_date column nahi hai
        $tasks = $query->orderBy('deadline', 'asc')->paginate(12);

        // Make sure you have a resources/views/supervisor/tasks.blade.php file
        return view('supervisor.tasks', compact('supervisor', 'tasks'));
    }

    /**
     * Update the specified task status in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validate the incoming request
        $request->validate([
            'status' => 'required|string|in:Pending,In Progress,Completed'
        ]);

        // 2. Find the task and update it
        $task = Task::findOrFail($id);
        $task->status = $request->status;
        $task->save();

        // 3. Redirect back with a success message
        return redirect()->back()->with('success', 'Task status updated successfully!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully!');
    }
}
