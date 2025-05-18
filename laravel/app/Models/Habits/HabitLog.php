<?php

namespace app\Models\Habits;

use app\Models\BaseModel;
use app\Models\DayOfWeek\DayOfWeek;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HabitLog extends BaseModel
{
    /** @use HasFactory<\Database\Factories\HabitLogFactory> */
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
