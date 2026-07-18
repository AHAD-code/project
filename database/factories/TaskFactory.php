<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Intern;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'intern_id' => Intern::inRandomOrder()->first()->id ?? 1,
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'deadline' => fake()->dateTimeBetween('now', '+2 weeks'),
            'priority' => fake()->randomElement(['Low', 'Medium', 'High']),
            'status' => fake()->randomElement(['Pending', 'In Progress', 'Completed']),
        ];
    }
}
