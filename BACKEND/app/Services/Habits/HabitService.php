<?php

namespace App\Services\Habits;

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
        return $this->builder()->with(['days', 'logs'])->where('user_id', $userId)->get();
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

    public function update(int $habitId, array $data): ?Habit
    {
        $habit = $this->builder()->find($habitId);

        if (!$habit) {
            return null;
        }

        $habit->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'reminder_time' => $data['reminder_time'] ?? null,
        ]);

        $habit->days()->sync($data['day_ids'] ?? []);
        $this->cleanUpLogs($habit);
        $this->generateLogs($habit);

        return $habit;
    }

    public function updateLog(int $habitId, array $data): HabitLog
    {
        $habit = $this->builder()->findOrFail($habitId);

        $log = $habit->logs()->firstOrCreate(
            ['date' => $data['date']],
            ['is_done' => $data['is_done']]
        );

        if ($log->is_done !== $data['is_done']) {
            $log->update(['is_done' => $data['is_done']]);
        }

        return $log;
    }

    public function delete(int $habitId, int $userId): bool
    {
        $query = $this->builder()
            ->where('id', $habitId)
            ->where('user_id', $userId);

        return (bool)$query->delete();
    }

    public function generateLogs(Habit $habit): void
    {
        $start = now();
        $end = now()->addMonth();
        $dayIds = $habit->days->pluck('id')->toArray();

        $current = $start->copy();
        while ($current <= $end) {
            if (in_array($current->dayOfWeek, $dayIds)) {
                HabitLog::firstOrCreate([
                    'habit_id' => $habit->id,
                    'date' => $current->format('Y-m-d'),
                ], [
                    'day_id' => $current->dayOfWeek,
                    'is_done' => 0,
                ]);
            }
            $current->addDay();
        }
    }

    protected function cleanUpLogs(Habit $habit): void
    {
        $validDayIds = $habit->days->pluck('id')->toArray();

        HabitLog::where('habit_id', $habit->id)
            ->whereNotIn('day_id', $validDayIds)
            ->where('date', '>=', now())
            ->delete();
    }


    public function updateMissedLogs(): void
    {
        HabitLog::where('date', '<', now())
            ->where('is_done', 0)
            ->update(['is_done' => 2]);
    }

}
