<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Checking Redis With Job & Queue
/*Route::get('/', function () {
    \Mail::to('sharmila@cloudrevelinnovation.com')->send(new \App\Mail\SendTestMail());
    return view('welcome');
});*/
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function(){
    
    Route::get('/dashboard', function () { 
        // Checking Redis With Job & Queue
        /*         
        for($i=0; $i<=20; $i++)
        dispatch(new \App\Jobs\SendEmailJob());
        */
        return view('dashboard'); 
    })->name('dashboard');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
require __DIR__.'/manager-auth.php';
