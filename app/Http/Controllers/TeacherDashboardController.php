<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // 🔐 ensure teacher exists
        $teacher = $user->teacher;

        $sections = $teacher
            ? $teacher->sections()
                ->with([
                    'semester.course',
                    'students',        // 🔥 only students of THIS section
                ])
                ->withCount('students') // 🔥 student count per section
                ->get()
            : collect();

        return Inertia::render('Teacher/Dashboard', [
            'stats' => [
                'total_sections' => $sections->count(),
                'total_students' => $sections->sum('students_count'),
            ],
            'myClasses' => $sections,
        ]);
    }
}
