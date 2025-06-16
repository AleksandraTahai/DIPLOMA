<?php

namespace app\Services\Habits;

use App\Contracts\Services\Habits\HabitServiceInterface;
use App\Models\Habits\Habit;
use App\Models\Habits\HabitLog;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class HabitService implements HabitServiceInterface
{
    protected function builder(): Builder
    {
        return Habit::query();
    }

    public function getAll(int $userId): Collection
    {
        return $this->builder()->with('days')->where('user_id', $userId)->get();
    }

    public function getById(int $habitId, int $userId): ?Habit
    {
        $habit = $this->builder();
        return $habit->with(['days', 'logs'])
            ->where('id', $habitId)
            ->where('user_id', $userId)
            ->first();
    }


    public function create(array $data): ?Habit
    {
        $habit = Habit::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'reminder_time' => $data['reminder_time'] ?? null,
            'user_id' => $data['user_id'],
        ]);

        $habit->days()->sync($data['day_ids'] ?? []);
        $this->generateLogs($habit);

        return $habit;

    }

    public function update(int $id, array $data): bool
    {
        $habit = $this->builder()->find($id);

        $habit->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'reminder_time' => $data['reminder_time'] ?? null,
        ]);

        $habit->days()->sync($data['day_ids'] ?? []);
        $this->generateLogs($habit);

        return $habit;
    }

    public function deleteById($id): bool
    {
        return Habit::find($id)->delete();
    }

    public function generateLogs(Habit $habit): void
    {
        $start = now();
        $end = now()->addWeek();
        $dayIds = $habit->days->pluck('id')->toArray();

        $current = $start->copy();
        while ($current <= $end) {
            if (in_array($current->dayOfWeek, $dayIds)) {
                HabitLog::firstOrCreate([
                    'habit_id' => $habit->id,
                    'date' => $current->toDateString(),
                ], [
                    'day_id' => $current->dayOfWeek,
                    'is_done' => 0,
                ]);
            }
            $current->addDay();
        }
    }

    public function updateMissedLogs(): void
    {   $habit = $this->builder();
        $habit->where('date', '<', now()->toDateString())
            ->where('is_done', 0)
            ->update(['is_done' => 2]);
    }

}
