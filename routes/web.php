<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\SupervisorTaskController;
use App\Http\Controllers\SupervisorAttendanceController;
use App\Http\Controllers\WeeklyReportController;
use App\Http\Controllers\InternPortalController;
use App\Http\Controllers\InternApplicationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// -----------------------------------------------------
// The Traffic Cop: Redirects users after login
// -----------------------------------------------------
Route::get('/dashboard', function () {
    $user = Auth::user();


    // Check role and redirect accordingly
    if ($user->role === 'supervisor') {
        return redirect()->route('supervisor.dashboard');
    } elseif ($user->role === 'admin') {
        // You can change this to an admin dashboard route later
        return redirect()->route('profile.edit');
    }

    // Default fallback for interns
    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// -----------------------------------------------------
// Student Routes (Intern Dashboard & Application)
// -----------------------------------------------------
// Consolidated into a single, clean group
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/student/dashboard', [InternPortalController::class, 'index'])->name('student.dashboard');
    Route::put('/tasks/{id}/update', [InternPortalController::class, 'updateTask'])->name('tasks.update');

    // Application Portal Submission
    Route::post('/student/apply', [InternApplicationController::class, 'store'])->name('student.apply.store');
});

// -----------------------------------------------------
// Supervisor Dashboard & Pages
// -----------------------------------------------------
Route::middleware(['auth', 'verified'])
    ->prefix('supervisor')
    ->name('supervisor.')
    ->group(function () {
        Route::get('/dashboard', [SupervisorController::class, 'index'])->name('dashboard');

        // Tasks Management
        Route::get('/tasks', [SupervisorTaskController::class, 'index'])->name('tasks');
        Route::put('/tasks/{id}', [SupervisorTaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{id}', [SupervisorTaskController::class, 'destroy'])->name('tasks.destroy');

        // Attendance Management
        Route::get('/attendance', [SupervisorAttendanceController::class, 'index'])->name('attendance');
        Route::get('/attendance/create', [SupervisorAttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance', [SupervisorAttendanceController::class, 'store'])->name('attendance.store');
        Route::put('/attendance/{id}', [SupervisorAttendanceController::class, 'update'])->name('attendance.update');

        // Weekly Reports & Applications
        Route::get('/reports', [WeeklyReportController::class, 'index'])->name('reports');

        // Added the missing route for Supervisors to download CVs securely
        Route::get('/reports/{id}/download-cv', [WeeklyReportController::class, 'downloadCv'])->name('reports.download-cv');
});

// -----------------------------------------------------
// Application Resource Routes (Admin Level)
// -----------------------------------------------------
Route::middleware(['auth'])->group(function () {
    Route::resource('interns', InternController::class)->only(['store', 'update', 'destroy']);
    Route::resource('supervisors', SupervisorController::class)->only(['index', 'store', 'update', 'destroy']);
});

// -----------------------------------------------------
// Profile Routes
// -----------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
