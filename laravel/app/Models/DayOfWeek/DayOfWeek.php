<?php

namespace app\Models\DayOfWeek;

use app\Models\BaseModel;
use app\Models\Habits\Habit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DayOfWeek extends BaseModel
{
    /** @use HasFactory<\Database\Factories\DayOfWeekFactory> */
    use HasFactory;

    public $timestamps = false;

    public function habits(): BelongsToMany
    {
        return $this->belongsToMany(Habit::class, 'habit_day');
    }
}
