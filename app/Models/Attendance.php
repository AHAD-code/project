<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory; // Required for the seeder to work

    protected $guarded = [];

    // Relationship back to the Intern
    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
