<?php

use App\Http\Controllers\{EventController, ProfileController, UserController};
use Illuminate\Support\Facades\Route;

Route::get('/home', [EventController::class, "showIndex"]);
Route::post('/event', [EventController::class, "showDetails"]);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'showIndex']);
    Route::post('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::delete('/events/{id}', [EventController::class, 'softDelete']);
});

require __DIR__ . '/auth.php';
