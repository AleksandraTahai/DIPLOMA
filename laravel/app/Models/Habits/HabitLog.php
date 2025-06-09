<?php

namespace App\Models\Habits;

use App\Models\BaseModel;
use App\Models\DayOfWeek\DayOfWeek;
use database\factories\Habits\HabitLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property int $habit_id
 * @property int $day_id
 * @property string $date
 * @property int $is_done
 * @property \Illuminate\Support\Carbon|null $create_time
 * @property \Illuminate\Support\Carbon|null $update_time
 * @property-read DayOfWeek $day
 * @property-read \App\Models\Habits\Habit $habit
 * @method static \Database\Factories\Habits\HabitLogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitLog whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitLog whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitLog whereDayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitLog whereHabitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitLog whereIsDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitLog whereUpdateTime($value)
 * @mixin \Eloquent
 */
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

    public function isOverdue(){
        return $this->date < now() && $this->is_done == 2;
    }
}
