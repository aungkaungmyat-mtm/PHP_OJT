<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return Inertia::render('Profile/Register');
    })->name('profile');
    Route::post('/profile/register', [ProfileController::class, 'register'])->name('profile.register');
    Route::post('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::delete('/profile/delete', [ProfileController::class, 'delete'])->name('profile.delete');
});

Route::middleware('auth')->group(function () {
   Route::get('/user', [UserController::class, 'index'])->name('user.list');
});


require __DIR__.'/auth.php';
