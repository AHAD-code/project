<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    use HasFactory; // Required for the seeder to work

    // Best Practice: Explicitly define which columns can be mass-assigned
    protected $fillable = [
        'supervisor_id',
        'name',
        'email',
        'registration_number',
        'department',
        'university',
        'cv_path',
        'task',
        'status',
        'progress',
        'start_date',
        'end_date'
    ];

    // Cast the dates so Laravel automatically treats them as Carbon objects
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'progress' => 'integer',
    ];

    // Relationship to Supervisor
    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    // Relationship to Tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Relationship to Attendance
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // --- Added relationships based on your database tables ---

    // Relationship to Weekly Reports
    public function weeklyReports()
    {
        return $this->hasMany(WeeklyReport::class);
    }

    // Relationship to Applications
    public function application()
    {
        return $this->hasOne(Application::class); // Use belongsTo() if the foreign key is in the interns table
    }
}
