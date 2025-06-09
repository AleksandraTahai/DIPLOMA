<?php

namespace App\Models\Habits;

use App\Models\BaseModel;
use App\Models\DayOfWeek\DayOfWeek;
use App\Models\User;
use database\factories\Habits\HabitFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $reminder_time
 * @property int $user_id
 * @property Carbon|null $create_time
 * @property Carbon|null $update_time
 * @method static Builder<static>|Habit newModelQuery()
 * @method static Builder<static>|Habit newQuery()
 * @method static Builder<static>|Habit query()
 * @method static Builder<static>|Habit whereCreateTime($value)
 * @method static Builder<static>|Habit whereDescription($value)
 * @method static Builder<static>|Habit whereId($value)
 * @method static Builder<static>|Habit whereReminderTime($value)
 * @method static Builder<static>|Habit whereTitle($value)
 * @method static Builder<static>|Habit whereUpdateTime($value)
 * @method static Builder<static>|Habit whereUserId($value)
 * @property-read Collection<int, \app\Models\DayOfWeek\DayOfWeek> $days
 * @property-read int|null $days_count
 * @property-read User $user
 * @property-read Collection<int, \App\Models\Habits\HabitLog> $logs
 * @property-read int|null $logs_count
 * @method static \Database\Factories\Habits\HabitFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Habit extends BaseModel
{
    /** @use HasFactory<HabitFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(DayOfWeek::class, 'habit_day', 'habit_id', 'day_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(HabitLog::class);
    }

    /**
     * @return Attribute
     */
    protected function title(): Attribute
    {
        return new Attribute(
            set: fn($value) => ucfirst($value),
        );
    }

    public function isActiveDay(Carbon $day): bool
    {
        return $this->days->contains($day->dayOfWeek);
    }
}
