<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Supervisor;
use App\Models\Intern;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Seeder Logic
        User::updateOrCreate(
            ['email' => 'admin@pel.com'],
            [
                'name' => 'Super Admin',
                'password' => 'password123', // The 'hashed' cast on the User model handles hashing.
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Supervisor Seeder Logic
        Supervisor::updateOrCreate(['email' => 'tariq.architect@pel.com.pk'], [
            'name' => 'Mr. Tariq',
            'department' => 'Information Technology',
            'designation' => 'Lead Software Architect',
        ]);
        Supervisor::factory(9)->create();

        // Intern Seeder Logic to include task and attendance data
        $supervisorIds = Supervisor::pluck('id');

        if ($supervisorIds->isEmpty()) {
            return; // No supervisors to assign interns to
        }

        $interns = [];
        for ($i = 0; $i < 20; $i++) {
            $interns[] = Intern::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'registration_number' => 'FA21-BCS-' . str_pad(fake()->unique()->numberBetween(1, 500), 3, '0', STR_PAD_LEFT),
                'department' => fake()->randomElement(['Computer Science', 'Software Engineering', 'Electrical Engineering']),
                'university' => 'COMSATS University Islamabad',
                'cv_path' => 'cvs/placeholder.pdf',
                'supervisor_id' => $supervisorIds->random(),
                'status' => fake()->randomElement(['Active', 'On-leave', 'Completed']),
                'progress' => fake()->numberBetween(0, 100),
                'start_date' => now()->subDays(rand(1, 30)),
                'end_date' => now()->addDays(rand(60, 90)),
            ]);
        }

        // Seeder logic for Tasks and Attendance
        // Note: Ensure Task model has the necessary fields in its $fillable property.
        foreach ($interns as $intern) {
            // Create 2-5 tasks for each intern
            for ($j = 0; $j < rand(2, 5); $j++) {
                Task::create([
                    'intern_id' => $intern->id,
                    'supervisor_id' => $intern->supervisor_id,
                    'title' => fake()->sentence(6),
                    'description' => fake()->paragraph(3),
                    'due_date' => fake()->dateTimeBetween('+1 week', '+2 months'),
                    'status' => fake()->randomElement(['Pending', 'In Progress', 'Completed', 'Cancelled']),
                    'priority' => fake()->randomElement(['High', 'Medium', 'Low']),
                ]);
            }

            // Create attendance records for each intern for the past 30 days
            for ($k = 0; $k < 30; $k++) {
                DB::table('attendances')->insert([
                    'intern_id' => $intern->id,
                    'date' => now()->subDays($k)->toDateString(),
                    'status' => fake()->randomElement(['Present', 'Absent', 'Leave']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
