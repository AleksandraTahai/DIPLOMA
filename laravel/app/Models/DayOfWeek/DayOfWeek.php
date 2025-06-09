<?php

namespace App\Models\DayOfWeek;

use App\Models\BaseModel;
use App\Models\Habits\Habit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \app\Models\Habits\Habit> $habits
 * @property-read int|null $habits_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayOfWeek newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayOfWeek newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayOfWeek query()
 * @property int $id
 * @property string $day
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayOfWeek whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayOfWeek whereId($value)
 * @mixin \Eloquent
 */
class DayOfWeek extends BaseModel
{
    /** @use HasFactory<\Database\Factories\DayOfWeekFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $table = 'day_of_weeks';

    public function habits(): BelongsToMany
    {
        return $this->belongsToMany(Habit::class, 'habit_day');
    }
}
