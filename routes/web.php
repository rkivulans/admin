<?php

use App\Http\Controllers\AliasController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProfileController;
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

/*
Route::middleware('auth')->group(function () {
    Route::get('/emails', [EmailController::class, 'index'])->name('emails');
    Route::get('/aliases', [AliasController::class, 'index'])->name('aliases');
});
*/

Route::resource('emails', EmailController::class)
    ->only(['index', 'create', 'edit', 'store'])
    ->middleware(['auth', 'verified']);

Route::resource('aliases', AliasController::class)
    ->only(['index', 'create', 'edit', 'store', 'update'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
