<?php

namespace Database\Seeders;

use App\Models\Habits\Habit;
use App\Models\User;
use Illuminate\Database\Seeder;

class HabitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        Habit::factory()
            ->count(4)
            ->create([
                'user_id' => $user->id,
            ])
            ->each(function (Habit $habit) {
                $habit->days()->attach([0, 4]);
            });

    }
}
