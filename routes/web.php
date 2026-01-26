<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\TeacherAssignmentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\UsersController;
use App\Models\Course;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// -------------------------------------------------------------------

// admin dashboard
Route::get('dashboard', function () {
   return Inertia::render('Dashboard', [
        'stats' => [
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_course'    => Course::count(),
            'total_section'    => Section::count(),
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::post(
    '/users/{user}/teacher',
    [UsersController::class, 'storeOrUpdateTeacher']
)->middleware(['auth', 'role:admin']);

Route::post(
    '/users/{user}/student',
    [UsersController::class, 'storeOrUpdateStudent']
)->name('users.student.store');


Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get(
        '/teacher/assignments/create',
        [TeacherAssignmentController::class, 'create']
    )->name('teacher.assignments.create');

    Route::post(
        '/teacher/assignments',
        [TeacherAssignmentController::class, 'store']
    )->name('teacher.assignments.store');
});


// teacherDashbord
Route::get('/TeacherDash',[TeacherDashboardController::class, 'index'])->name('TeacherDash');

// -------------------------------------------------------------------

// chat boat
Route::get('/boat', function () {
    return Inertia::render('ChactBot/Index');
})->name('boat');

// -------------------------------------------------------------------

// profile page
Route::get('/profile', [ProfileController::class, 'show'])
    ->middleware('auth');
Route::put('/teacher/profile/basic', [ProfileController::class, 'updateBasic'])
    ->middleware(['auth', 'role:teacher|admin']);

Route::get('/student/profile', [StudentProfileController::class, 'show'])
    ->middleware(['auth', 'role:user|student']);

Route::put('/student/profile/basic', [StudentProfileController::class, 'updateBasic'])
    ->middleware(['auth', 'role:student'])
    ->name('student.profile.basic.update');

// -------------------------------------------------------------------

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
    Route::resource('roles', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('semesters', SemesterController::class);
    Route::resource('sections', SectionController::class);
});

require __DIR__.'/settings.php';

// -------------------------------------------------------------------

// student and teacher store or update routes
Route::post('/users/{id}/student', [StudentController::class, 'storeOrUpdate']);
Route::post('/users/{id}/teacher', [TeacherController::class, 'storeOrUpdate']);

// -------------------------------------------------------------------
