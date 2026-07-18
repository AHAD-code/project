<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Intern;

class AttendanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'intern_id' => Intern::inRandomOrder()->first()->id ?? 1,
            'date' => fake()->dateTimeBetween('-1 week', 'now'),
            'status' => fake()->randomElement(['Present', 'Present', 'Present', 'Absent', 'Leave']), // Weighted towards Present
        ];
    }
}
