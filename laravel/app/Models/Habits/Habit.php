<?php

namespace app\Models\Habits;

use App\Models\BaseModel;
use App\Models\DayOfWeek\DayOfWeek;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $reminder_time
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $create_time
 * @property \Illuminate\Support\Carbon|null $update_time
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereReminderTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereUpdateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \app\Models\DayOfWeek\DayOfWeek> $days
 * @property-read int|null $days_count
 * @property-read \app\Models\Users\User $user
 * @mixin \Eloquent
 */
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
