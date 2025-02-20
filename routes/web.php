<?php

use App\Http\Controllers\{EventController, ProfileController, UserController};
use Illuminate\Support\Facades\Route;

Route::get('/home', [EventController::class, "showIndex"]);
Route::post('/event', [EventController::class, "showDetails"])->name('event.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'showIndex']);
    Route::post('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::delete('/events/{id}', [EventController::class, 'softDelete'])->name('event.softDelete');
    Route::post('/events', [EventController::class, 'insert'])->name('event.create');
});

require __DIR__ . '/auth.php';
