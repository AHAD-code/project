<?php

namespace App\Http\Controllers;

use App\Models\WeeklyReport;
use App\Models\Application;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WeeklyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $startOfWeek = Carbon::now()->startOfWeek();

        $applications = Application::where('created_at', '>=', $startOfWeek)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('supervisor.reports', compact('applications'));
    }

    /**
     * Download the applicant's CV securely using Absolute Paths.
     */
    public function downloadCv($id)
    {
        $application = Application::findOrFail($id);

        if (empty($application->cv_path)) {
            return back()->with('error', 'There is no CV path saved in the database for this user.');
        }

        // Generate the absolute physical path to the file on the server
        $absolutePath = storage_path('app/public/' . $application->cv_path);

        // Check if the physical file actually exists
        if (!file_exists($absolutePath)) {
            return back()->with('error', 'File not found on server. It may not have uploaded correctly.');
        }

        // Extract extension and format a clean file name
        $extension = pathinfo($application->cv_path, PATHINFO_EXTENSION);
        $downloadName = str_replace(' ', '_', $application->name) . '_CV.' . $extension;

        // Force browser download using the absolute path
        return response()->download($absolutePath, $downloadName);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WeeklyReport $weeklyReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WeeklyReport $weeklyReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WeeklyReport $weeklyReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WeeklyReport $weeklyReport)
    {
        //
    }
}
