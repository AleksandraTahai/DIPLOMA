<?php

namespace Database\Factories\Habits;

use App\Models\Habits\Habit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Habit>
 */
class HabitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'reminder_time' => $this->faker->time('H:i:s'),
            'user_id' => 1,
        ];
    }
}
