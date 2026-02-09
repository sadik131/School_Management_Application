<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\AssignmentSubmission;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $teacher = $request->user()->teacher;

    $assignments = $teacher->assignments()
        ->with('section.semester.course')
        ->latest()
        ->get()
        ->map(function ($a) {

            $totalStudents = Student::where('section_id', $a->section_id)->count();

            $submittedCount = AssignmentSubmission::where('assignment_id', $a->id)->count();

            return [
                'id' => $a->id,
                'title' => $a->title,
                'section' => $a->section,
                'due_date' => Carbon::parse($a->due_date)->format('d M Y'),
                'submitted' => $submittedCount,
                'pending' => $totalStudents - $submittedCount,
            ];
        });

    return Inertia::render('Teacher/Assignments/Index', [
        'assignments' => $assignments,
        'totalAssignments' => $assignments->count(),
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $teacher = $request->user()->teacher;
        $sections = $teacher->sections()
            ->with('semester.course')
            ->get();

        return Inertia::render('Teacher/Create', [
            'sections' => $sections,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);
        $teacher = $request->user()->teacher;

        abort_unless(
            $teacher->sections()->where('sections.id', $request->section_id)->exists(),
            403
        );

        Assign::create([
            'teacher_id' => $teacher->id,
            'section_id' => $request->section_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return redirect()
            ->route('TeacherDash')
            ->with('success', 'Assignment created successfully');
    }

    public function check($sectionId, Assign $assignment)
    {
        // safety: assignment must belong to section
        abort_if($assignment->section_id != $sectionId, 404);

        $submissions = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->with('student.user')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'student_name' => $s->student->user->name,
                    'roll' => $s->student->roll_number,
                    'answer_text' => $s->answer_text,
                    'marks' => $s->marks,
                ];
            });


        return Inertia::render('Teacher/Assignments/Check', [
            'assignment' => [
                'id' => $assignment->id,
                'title' => $assignment->title,
            ],
            'submissions' => $submissions,
        ]);
    }

    public function storeMarks(Request $request, Assign $assignment)
    {
        AssignmentSubmission::where('id', $request->submission_id)
            ->update(['marks' => $request->marks]);

        return back()->with('success', 'Marks saved');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
