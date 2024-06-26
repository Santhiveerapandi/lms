<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
});

// Route::group(['middleware' => ['role:admin,admin']], function () { 
    Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {

        /**
         * ACL Started
         */
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
    

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->middleware(['auth:admin', 'verified'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        Route::resource('employee', EmployeeController::class);
        Route::resource('course', CourseController::class);
    });
// });