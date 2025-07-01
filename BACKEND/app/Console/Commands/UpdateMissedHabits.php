<?php

namespace App\Console\Commands;

use App\Models\Habits\HabitLog;
use Illuminate\Console\Command;

class UpdateMissedHabits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'habits:update-missed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update missed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         HabitLog::where('date', '<', now())
            ->where('is_done', 0)
            ->update(['is_done' => 2]);
    }
}
