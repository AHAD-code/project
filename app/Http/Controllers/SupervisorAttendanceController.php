<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Supervisor;
use App\Models\Intern; // Make sure to import this
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisorAttendanceController extends Controller
{
    // ... existing index() method remains the same ...
    public function index(Request $request)
    {
        $supervisor = Supervisor::where('email', Auth::user()->email ?? '')->first();
        if (!$supervisor) { $supervisor = Supervisor::first(); }
        $supervisorId = $supervisor ? $supervisor->id : 0;

        $query = Attendance::whereHas('intern', function($q) use ($supervisorId) {
            $q->where('supervisor_id', $supervisorId);
        })->with('intern');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('intern', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(15);
        return view('supervisor.attendance', compact('supervisor', 'attendances'));
    }

    // --- ADD THESE NEW METHODS ---

    public function create()
    {
        // Get the current supervisor
        $supervisor = Supervisor::where('email', Auth::user()->email ?? '')->first();

        // Get only interns assigned to this supervisor
        $interns = Intern::where('supervisor_id', $supervisor->id)->get();

        return view('supervisor.attendance_create', compact('interns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'intern_id' => 'required|exists:interns,id',
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent,Leave',
        ]);

        Attendance::create([
            'intern_id' => $request->intern_id,
            'date' => $request->date,
            'status' => $request->status,
        ]);

        return redirect()->route('supervisor.attendance')->with('success', 'Attendance added successfully.');
    }

    // ... your existing update() method remains below ...
    public function update(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:Present,Absent,Leave']);
        $attendance = Attendance::findOrFail($id);

        $supervisorEmail = Auth::user()->email ?? '';
        $supervisor = Supervisor::where('email', $supervisorEmail)->first() ?? Supervisor::first();

        if ($attendance->intern->supervisor_id !== $supervisor->id) {
            abort(403, 'Unauthorized action.');
        }

        $attendance->update(['status' => $request->status]);
        return back()->with('success', 'Attendance record updated successfully.');
    }
}
