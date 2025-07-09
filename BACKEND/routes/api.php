<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HabitController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user',[AuthController::class, 'user']);
    Route::get('/habits', [HabitController::class, 'index']);
    Route::get('/habits/{id}', [HabitController::class, 'show']);
    Route::post('/habits', [HabitController::class, 'store']);
    Route::put('/habits/{id}', [HabitController::class, 'update']);
    Route::post('/habits/{id}/log', [HabitController::class, 'updateLog']);
    Route::delete('/habits/{id}', [HabitController::class, 'destroy']);
});



