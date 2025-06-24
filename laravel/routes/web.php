<?php

use App\Http\Controllers\HabitController;
use App\Mail\HabitReminderMail;
use App\Models\Habits\Habit;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('habits', HabitController::class);

//Route::get('/mail', function () {
//    $mail=new HabitReminderMail(Habit::first());
//    Mail::send($mail);
//
//});
