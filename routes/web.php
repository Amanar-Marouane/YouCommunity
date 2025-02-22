<?php

use App\Http\Controllers\{CommentController, EventController, ProfileController, RsvpController, UserController};
use Illuminate\Support\Facades\Route;

Route::get('/home', [EventController::class, "showIndex"]);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'showIndex'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post("/event/reserve", [RsvpController::class, "reserve"])->name('event.reserve');
    Route::post("/event/cancel", [RsvpController::class, "cancel"])->name('event.cancel');
    Route::post('/event/comment', [CommentController::class, 'insert'])->name('comment.create');
    Route::post('/events', [EventController::class, 'insert'])->name('event.create');
    Route::patch('/events', [EventController::class, 'update'])->name('event.update');
    Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::delete('/events/{id}', [EventController::class, 'softDelete'])->name('event.softDelete');
});
Route::get('/event/{id}', [EventController::class, "showDetails"])->name('event.show');

require __DIR__ . '/auth.php';
