<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherDashboardController extends Controller
{
    public function index(Request $request)
{
    $user = $request->user();
    $teacher = $user->teacher;

    // total assignments by this teacher
    $totalAssignments = Assign::where('teacher_id', $teacher->id)->count();

    $sections = $teacher
        ? $teacher->sections()
            ->with([
                'semester.course',
                'students',
            ])
            ->withCount('students')
            ->get()
        : collect();

    $totalStudents = $sections->sum('students_count');

    $totalSubmissions = AssignmentSubmission::whereIn(
        'assignment_id',
        Assign::where('teacher_id', $teacher->id)->pluck('id')
    )->count();

    $totalPending = max(
        0,
        ($totalStudents * $totalAssignments) - $totalSubmissions
    );

    return Inertia::render('Teacher/Dashboard', [
        'stats' => [
            'total_sections' => $sections->count(),
            'total_students' => $totalStudents,
            'total_assignments' => $totalAssignments,
            'total_submissions' => $totalSubmissions,
            'total_pending' => $totalPending,
        ],
        'myClasses' => $sections,
    ]);
}

}
