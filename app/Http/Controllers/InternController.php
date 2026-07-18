<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;

class InternController extends Controller
{
    public function index()
    {
        // Fetch real data from the database with pagination
        $interns = Intern::latest()->paginate(10);

        return view('interns.index', compact('interns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:interns',
            'department' => 'required|string',
            'task' => 'required|string',
            'status' => 'required|string',
        ]);

        Intern::create($validated);

        return back()->with('success', 'Intern added successfully.');
    }

    public function update(Request $request, Intern $intern)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:interns,email,' . $intern->id,
            'department' => 'required|string',
            'task' => 'required|string',
            'status' => 'required|string',
        ]);

        $intern->update($validated);

        return back()->with('success', 'Intern updated successfully.');
    }

    public function destroy(Intern $intern)
    {
        $intern->delete();

        return back()->with('success', 'Intern removed successfully.');
    }
}
