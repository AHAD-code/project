<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application; // We changed this from Intern to Application

class InternApplicationController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate data (Notice we changed the unique check to the applications table)
        $request->validate([
            'university' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255|unique:applications,registration_number',
            'cv_file' => 'required|file|mimes:pdf,docx,zip|max:5120',
        ]);

        $user = Auth::user();

        // 2. Upload the CV safely
        $cvPath = null;
        if ($request->hasFile('cv_file')) {
            $cvPath = $request->file('cv_file')->store('intern_cvs', 'public');
        }

        // 3. Save the data to your brand new 'applications' table
        Application::create([
            'name' => $user->name,
            'email' => $user->email,
            'university' => $request->input('university'),
            'department' => $request->input('department'),
            'registration_number' => $request->input('registration_number'),
            'cv_path' => $cvPath,
            'status' => 'Pending',
        ]);

        // 4. Redirect back
        return redirect()->route('student.dashboard')->with('success', 'Application submitted successfully! Your profile is under review.');
    }
}
