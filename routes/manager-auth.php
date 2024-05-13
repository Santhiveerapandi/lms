<?php

use App\Http\Controllers\Manager\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Manager\Auth\PasswordController;
use App\Http\Controllers\Manager\Auth\RegisteredUserController;
use App\Http\Controllers\Manager\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:manager')->prefix('manager')->name('manager.')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
});

Route::middleware('auth:manager')->prefix('manager')->name('manager.')->group(function () {

    Route::get('/dashboard', function () {
        return view('manager.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
