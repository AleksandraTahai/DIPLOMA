<?php

namespace App\Models\Habits;

use App\Models\BaseModel;
use App\Models\DayOfWeek\DayOfWeek;
use database\factories\Habits\HabitLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HabitLog extends BaseModel
{
    /** @use HasFactory<HabitLogFactory> */
    use HasFactory;

    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class, 'habit_id');
    }

    public function day(): BelongsTo
    {
        return $this->belongsTo(DayOfWeek::class, 'day_id');
    }
}
