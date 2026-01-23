<?php

use App\Http\Controllers\Permission;
use App\Http\Controllers\PermissionController;
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


// -------------------------------------------------------------------


// admin dashboard 
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// teacherDashbord
Route::get('/TeacherDash', function () {
    return Inertia::render('Teacher/Dashboard');
})->name('TeacherDash');

// -------------------------------------------------------------------

// chat boat
Route::get('/boat', function () {
    return Inertia::render('ChactBot/Index');
})->name('boat');

// -------------------------------------------------------------------
// profile page
Route::get('/profile', function () {
    return Inertia::render('profile/Index');
})->name('profile');

// student profile
Route::get('/student', function () {
    return Inertia::render('profile/Stu');
})->name('student');


// teacher page
Route::get('/teacher/assignments', function () {
    return Inertia::render('Teacher/Assignments/Index');
})->name('teacher.assignments');

Route::get('/teacher/assignments/check', function () {
    return Inertia::render('Teacher/Assignments/Check');
})->name('teacher.assignments.check');


// -------------------------------------------------------------------


Route::middleware(['role:admin'])->group(function () {
    Route::resource('users', UsersController::class);
});
Route::resource('roles',RoleController::class);
Route::resource('permission',PermissionController::class);

require __DIR__.'/settings.php';
