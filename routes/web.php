<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    // return Inertia::render('Welcome', [
    //     'canRegister' => Features::enabled(Features::registration()),
    // ]);
     return redirect()->route('login');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// profile page
Route::get('/profile', function () {
    return Inertia::render('profile/Index');
})->name('profile');

Route::get('/student', function () {
    return Inertia::render('profile/Stu');
})->name('student');



Route::resource('users',UsersController::class);
Route::resource('roles',RoleController::class);

require __DIR__.'/settings.php';
