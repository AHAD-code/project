<?php

namespace Database\Factories;

use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Supervisor>
 */
class SupervisorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'department' => fake()->randomElement([
                'Software Engineering',
                'Information Technology',
                'Data Science',
                'UI/UX Design',
                'DevOps'
            ]),
            'designation' => fake()->randomElement([
                'Lead Software Architect',
                'Senior Developer',
                'Project Manager',
                'Engineering Manager',
                'Tech Lead'
            ]),
        ];
    }
}
