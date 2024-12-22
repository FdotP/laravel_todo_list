<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\GoogleCalendarController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('tasks', TasksController::class)->middleware(['auth', 'verified']);

Route::post('/task/{id}/generate-link', [TasksController::class, 'generateShareLink'])->name('tasks.generate-link')->middleware(['auth', 'verified']);;

Route::get('/tasks/check/{id}', [TasksController::class, 'viewTask'])->name('tasks.check');

Route::get('auth/google', [GoogleCalendarController::class, 'redirectToGoogle'])->name('auth.google')->middleware(['auth', 'verified']);; 
Route::get('auth/google/callback', [GoogleCalendarController::class, 'handleGoogleCallback'])->middleware(['auth', 'verified']);;



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
