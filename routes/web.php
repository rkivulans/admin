<?php

use App\Http\Controllers\AliasController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('emails', EmailController::class)
        ->only(['index', 'create', 'edit', 'store', 'update']);

    Route::resource('aliases', AliasController::class)
        ->only(['index', 'create', 'edit', 'store', 'update']);

    Route::resource('users', UserController::class)
        ->only(['index', 'create', 'edit', 'store']);
});

require __DIR__.'/auth.php';
