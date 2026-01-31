<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // 🔐 ensure teacher exists
        $teacher = $user->teacher;
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

        return Inertia::render('Teacher/Dashboard', [
            'stats' => [
                'total_sections' => $sections->count(),
                'total_students' => $sections->sum('students_count'),
                'total_assignments' => $totalAssignments,
            ],
            'myClasses' => $sections,
        ]);
    }
}
