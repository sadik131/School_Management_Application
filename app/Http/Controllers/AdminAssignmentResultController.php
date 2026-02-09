<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\Student;
use App\Models\AssignmentSubmission;
use Inertia\Inertia;

class AdminAssignmentResultController extends Controller
{
    public function index(Assign $assignment)
    {
        // s All students of this section
        $students = Student::where('section_id', $assignment->section_id)
            ->with('user')
            ->get();

        // s All submissions for this assignment (keyed by student_id)
        $submissions = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->get()
            ->keyBy('student_id');

        // s Build result rows (ALL students)
        $results = $students->map(function ($student) use ($submissions) {

            $submission = $submissions->get($student->id);

            return [
                'student_name' => $student->user->name,
                'roll' => $student->roll_number,

                'submitted' => $submission !== null,

                'marks' => $submission?->marks,

                'status' => $submission
                    ? ($submission->marks !== null ? 'Graded' : 'Submitted')
                    : 'Not Submitted',
            ];
        });

        // s Summary stats (admin needs this)
        $totalStudents = $students->count();
        $submittedCount = $submissions->count();
        $gradedCount = $submissions->whereNotNull('marks')->count();
        $pendingCount = $totalStudents - $submittedCount;

        return Inertia::render('Admin/Assignments/Results', [
            'assignment' => [
                'title' => $assignment->title,
            ],

            'summary' => [
                'total_students' => $totalStudents,
                'submitted' => $submittedCount,
                'graded' => $gradedCount,
                'pending' => $pendingCount,
            ],

            'results' => $results,
        ]);
    }
}
