<?php

namespace Database\Seeders;

use App\Models\DayOfWeek\DayOfWeek;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DayOfWeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            'Воскресенье',
            'Понедельник',
            'Вторник',
            'Среда',
            'Четверг',
            'Пятница',
            'Суббота'
        ];

        foreach ($days as $key => $day) {
            DayOfWeek::insert([
                'id' => $key,
                'day' => $day
            ]);
        }
    }
}
