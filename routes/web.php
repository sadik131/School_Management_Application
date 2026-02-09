<?php

//   ------------------Controller--------------------------
use App\Http\Controllers\AdminAssignmentResultController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StudentAssignmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\TeacherAssignmentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\UsersController;
//   ------------------Controller End--------------------------

//   ------------------Models--------------------------

use App\Models\Assign;
use App\Models\Course;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
//   ------------------Models End --------------------------

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// -----------------------------    DASHBOARD  --------------------------------------

// admin dashboard
Route::get('/dashboard', function () {

    $user = auth()->user();

    // ADMIN
    if ($user->hasRole('admin')) {
        return Inertia::render('Dashboard', [
            'stats' => [
                'total_students' => Student::count(),
                'total_teachers' => Teacher::count(),
                'total_course' => Course::count(),
                'total_section' => Section::count(),
                'total_assignments' => Assign::count(),
                'assignment' => Assign::with(
                    'teacher',
                    'teacher.user',
                    'section',
                    'section.semester'
                )->latest()->take(5)->get(),
            ],
        ]);
    }

    // TEACHER
    if ($user->hasRole('teacher')) {
        return redirect()->route('TeacherDash');
    }

    // STUDENT
    if ($user->hasRole('student')) {
        return redirect()->route('dashboard.index');
    }

    abort(403);
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// teacherDashbord
Route::get('/TeacherDash', [TeacherDashboardController::class, 'index'])->name('TeacherDash');

// student dashboard
Route::resource('/Student/dashboard', StudentAssignmentController::class);

// -------------------------------------------------------------------

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

Route::get(
    '/teacher/sections/{section}/assignments/{assignment}/check',
    [TeacherAssignmentController::class, 'check']
)->name('teacher.assignments.check');

Route::post(
    '/teacher/assignments/{assignment}/marks',
    [TeacherAssignmentController::class, 'storeMarks']
)->name('teacher.assignments.marks');

Route::get('/teacher/section/{id}', [SectionController::class, 'show'])->name('teacher.section.show');

// -----------------------------Admin Route--------------------------------------

Route::middleware(['auth', 'role:admin'])->group(function () {
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

Route::get(
    '/teacher/ass',
    [TeacherAssignmentController::class, 'index']
)->name('teacher.assignments.index');

Route::get(
    '/admin/assignments/{assignment}/results',
    [AdminAssignmentResultController::class, 'index']
)->name('admin.assignments.results');




// -------------------------------------------------------------------

// talk with AI
Route::post('/ai/chat', [AIController::class, 'chat'])
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {

    Route::get('/student/assignments/{assignment}',
        [StudentAssignmentController::class, 'show']
    )->name('student.assignments.show');

    Route::post('/student/assignments/{assignment}/submit',
        [StudentAssignmentController::class, 'submit']
    )->name('student.assignments.submit');

});
