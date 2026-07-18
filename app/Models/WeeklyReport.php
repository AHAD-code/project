<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyReport extends Model
{
    // Allows mass assignment for all columns
    protected $guarded = [];

    /**
     * Relationship: A weekly report belongs to a specific intern.
     */
    public function intern()
    {
        return $this->belongsTo(Intern::class, 'intern_id');
    }

    /**
     * Relationship: A weekly report belongs to a specific supervisor.
     */
    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisor_id');
    }
}
