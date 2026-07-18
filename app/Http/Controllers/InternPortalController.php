<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InternPortalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Query the interns table using the unique user login email
        $intern = DB::table('interns')->where('email', $user->email)->first();

        // NEW LOGIC: If the user is NOT in the interns table, show the Application Portal
        if (!$intern) {
            return view('student.apply', compact('user'));
        }

        // If they ARE an intern, fetch their real-time dashboard data
        $tasks = DB::table('tasks')
            ->where('intern_id', $intern->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $supervisor = DB::table('supervisors')
            ->where('id', $intern->supervisor_id)
            ->first();

        $startOfWeek = Carbon::now()->startOfWeek();
        $attendances = DB::table('attendances')
            ->where('intern_id', $intern->id)
            ->where('created_at', '>=', $startOfWeek)
            ->get()
            ->keyBy(function($item) {
                return Carbon::parse($item->created_at)->format('D');
            });

        return view('student.dashboard', compact('intern', 'tasks', 'supervisor', 'attendances'));
    }

    public function updateTask(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:In Progress,Completed',
            'task_file' => 'nullable|file|mimes:zip,pdf,rar,docx|max:10240',
        ]);

        $user = Auth::user();
        $intern = DB::table('interns')->where('email', $user->email)->first();

        if (!$intern) {
            return back()->with('error', 'Authorized profile missing.');
        }

        $taskExists = DB::table('tasks')
            ->where('id', $id)
            ->where('intern_id', $intern->id)
            ->exists();

        if (!$taskExists) {
            abort(403, 'Unauthorized task operation.');
        }

        $updateData = ['status' => $request->input('status')];

        if ($request->hasFile('task_file')) {
            $path = $request->file('task_file')->store('task_submissions', 'public');
            $updateData['submission_path'] = $path;
        }

        DB::table('tasks')->where('id', $id)->update($updateData);

        return back()->with('success', 'Database records updated successfully!');
    }
}
