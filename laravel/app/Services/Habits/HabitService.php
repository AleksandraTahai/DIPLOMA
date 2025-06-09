<?php

namespace app\Services\Habits;

use App\Contracts\Services\Habits\HabitServiceInterface;
use App\Models\Habits\Habit;
use Illuminate\Support\Collection;

class HabitService implements HabitServiceInterface
{
    public function getAll(): Collection
    {
        return Habit::all();
    }

    public function getById(int $id): ?Habit
    {
        return Habit::find($id);
    }

    public function create(array $data): ?Habit
    {
        return Habit::create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'reminder_time' => $data['reminder_time'] ?? null,
                'user_id' => $data['user_id']
            ]
        );

    }

    public function update(int $id, array $data): bool
    {
        return Habit::find($id)->update($data);
    }

    public function deleteById($id): bool
    {
        return Habit::find($id)->delete();
    }

}
