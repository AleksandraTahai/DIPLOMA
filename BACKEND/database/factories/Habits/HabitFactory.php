<?php

namespace Database\Factories\Habits;

use App\Models\DayOfWeek\DayOfWeek;
use App\Models\Habits\Habit;
use App\Models\Habits\HabitLog;
use App\Models\User;
use Carbon\Carbon;
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
            'user_id' => User::factory(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Habit $habit) {
            $randomDaysOfWeek = DayOfWeek::inRandomOrder()->limit(3)->pluck('id')->toArray();
            $habit->days()->attach($randomDaysOfWeek);
            $start = Carbon::now()->subMonth();
            $end = Carbon::now()->addMonth();

            for ($date = $start->copy(); $date <= $end; $date->addDay()) {
                $dayOfWeek = $date->dayOfWeek;
                if (in_array($dayOfWeek, $randomDaysOfWeek)) {
                    HabitLog::factory()->create([
                        'habit_id' => $habit->id,
                        'day_id' => $dayOfWeek,
                        'date' => $date->format('Y-m-d'),
                        'is_done' => $date->isPast() ? rand(1, 2) : 0,  //1-done,2-missed,0-neutral
                    ]);

                }
            }

        });
    }
}
