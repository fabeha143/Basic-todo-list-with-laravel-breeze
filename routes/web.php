<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/todo', [TaskController::class, 'index'])->name('todo.index');
    Route::post('/todo', [TaskController::class, 'store'])->name('todo.store');
    Route::get('/todo/{id}/edit', [TaskController::class, 'edit'])->name('todo.edit');
    Route::patch('/todo/{id}', [TaskController::class, 'update'])->name('todo.update');
    Route::delete('/todo/{id}', [TaskController::class, 'destroy'])->name('todo.destroy');
});



require __DIR__.'/auth.php';
