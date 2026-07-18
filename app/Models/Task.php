<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * (Optional: Laravel assumes 'tasks' by default)
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     * Update these if you have different column names in your database migration.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',          // e.g., 'Pending', 'In Progress', 'Completed'
        'priority',        // e.g., 'High', 'Medium', 'Low'
        'intern_id',       // Foreign key for the assigned intern
        'supervisor_id',   // Foreign key for the assigning supervisor
        'due_date',
    ];

    /**
     * Relationship: A task belongs to an Intern.
     * This allows you to do $task->intern->name in your Blade files.
     */
    public function intern(): BelongsTo
    {
        return $this->belongsTo(Intern::class, 'intern_id');
    }

    /**
     * Relationship: A task belongs to a Supervisor.
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Supervisor::class, 'supervisor_id');
    }
}
