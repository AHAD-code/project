<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Supervisor;

class InternFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Assign to a random supervisor, or you can hardcode supervisor_id => 1 for Mr. Tariq
            'supervisor_id' => Supervisor::inRandomOrder()->first()->id ?? 1,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'registration_number' => 'FA23-' . fake()->unique()->numerify('####'),
            'department' => fake()->randomElement(['Software Engineering', 'Information Technology', 'UI/UX Design', 'DevOps']),
            'university' => fake()->randomElement(['Punjab University', 'FAST NUCES', 'COMSATS', 'LUMS']),
            'status' => fake()->randomElement(['Active', 'Active', 'Completed', 'Pending']), // Weighted towards Active
            'progress' => fake()->numberBetween(10, 100),
            'start_date' => fake()->dateTimeBetween('-3 months', 'now'),
            'end_date' => fake()->dateTimeBetween('now', '+3 months'),
        ];
    }
}
