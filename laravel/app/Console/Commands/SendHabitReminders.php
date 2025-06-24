<?php

namespace App\Console\Commands;

use App\Mail\HabitReminderMail;
use App\Models\Habits\Habit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendHabitReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-habit-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTime = now()->format('H:i');
        $habits = Habit::whereNotNull('reminder_time')
            ->where('reminder_time', $currentTime)
            ->with('user')
            ->get();

        foreach ($habits as $habit) {
            Mail::to($habit->user->email)->send(new HabitReminderMail($habit));
        }
    }
}
