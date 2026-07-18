<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use App\Models\Intern;
use App\Models\Task;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    public function index(Request $request)
    {
        // 1. Identify the logged-in supervisor.
        // Fallback to the first supervisor in the database if the user relationship isn't set up yet for testing.
        $supervisor = Supervisor::where('email', Auth::user()->email ?? '')->first();

        if (!$supervisor) {
            $supervisor = Supervisor::first();
        }

        $supervisorId = $supervisor ? $supervisor->id : 0;

        // Get the IDs of all interns assigned to this supervisor
        $internIds = Intern::where('supervisor_id', $supervisorId)->pluck('id');

        // 2. Fetch Assigned Interns (For the Card View)
        $query = Intern::where('supervisor_id', $supervisorId);

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('department', 'like', '%' . $request->search . '%');
            });
        }

        $interns = $query->paginate(6); // 6 per page for the card grid

        // 3. Calculate Dashboard Statistics (Date logic removed)
        $stats = [
            'total_interns' => Intern::where('supervisor_id', $supervisorId)->count(),
            'active_interns' => Intern::where('supervisor_id', $supervisorId)->where('status', 'Active')->count(),

            // Count pending tasks for the assigned interns
            'pending_tasks' => Task::whereIn('intern_id', $internIds)
                                   ->where('status', 'Pending')
                                   ->count(),

            // Hardcoded to 0 since date calculation is removed
            'present_today' => 0,
        ];

        // 4. Chart.js Data (Date loop removed)
        // Returning empty arrays so the frontend view doesn't throw an undefined variable error
        $chartLabels = [];
        $chartData = [];

        return view('supervisor.dashboard', compact('supervisor', 'interns', 'stats', 'chartLabels', 'chartData'));
    }

    // --------------------------------------------------------
    // CRUD Operations
    // --------------------------------------------------------

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:supervisors',
            'department' => 'required|string',
            'designation' => 'required|string',
        ]);

        Supervisor::create($validated);
        return back()->with('success', 'Supervisor added successfully.');
    }

    public function update(Request $request, Supervisor $supervisor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:supervisors,email,' . $supervisor->id,
            'department' => 'required|string',
            'designation' => 'required|string',
        ]);

        $supervisor->update($validated);
        return back()->with('success', 'Supervisor updated successfully.');
    }

    public function destroy(Supervisor $supervisor)
    {
        $supervisor->delete();
        return back()->with('success', 'Supervisor removed successfully.');
    }
}
