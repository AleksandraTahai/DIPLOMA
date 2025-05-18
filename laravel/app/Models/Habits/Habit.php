<?php

namespace app\Models\Habits;

use app\Models\BaseModel;
use app\Models\DayOfWeek\DayOfWeek;
use app\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habit extends BaseModel
{
    /** @use HasFactory<\Database\Factories\HabitFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(DayOfWeek::class, 'habit_day');
    }
}
