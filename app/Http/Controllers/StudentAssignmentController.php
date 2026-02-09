<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $student = $user->student;

        $student->load([
            'section.semester.course',
        ]);

        $assignments = Assign::where('section_id', $student->section_id)
            ->with(['submissions' => function ($q) use ($student) {
                $q->where('student_id', $student->id);
            }])
            ->get()
            ->map(function ($a) {
                $submission = $a->submissions->first();

                return [
                    'id' => $a->id,
                    'title' => $a->title,
                    'subject' => $a->subject ?? 'General',
                    'due_date' => \Carbon\Carbon::parse($a->due_date)->format('d M Y'),
                    'status' => $submission
                        ? 'Submitted'
                        : (now()->gt($a->due_date) ? 'Late' : 'Pending'),

                    'marks' => $submission?->marks,
                ];
            });

        return Inertia::render('Student/Index', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],

            'student' => [
                'student_id' => $student->student_id,
                'roll' => $student->roll_number,
                'course' => $student->section->semester->course->code,
                'semester' => $student->section->semester->name,
                'section' => $student->section->name,
            ],

            'assignments' => $assignments,

            'stats' => [
                'attendance' => 28,
                'submitted' => $assignments->where('status', 'Submitted')->count(),
                'pending' => $assignments->where('status', 'Pending')->count(),
                'examStatus' => 'Eligible',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Assign $assignment)
    {
        $student = auth()->user()->student;

        //  security check
        abort_if($assignment->section_id !== $student->section_id, 403);
        return Inertia::render('Student/AssignmentSubmit', [
            'assignment' => [
                'id' => $assignment->id,
                'title' => $assignment->title,
                'description' => $assignment->description,
                'due_date' => $assignment->due_date->format('d M Y'),
            ],
        ]);
    }

    public function submit(Request $request, Assign $assignment)
    {
        $student = auth()->user()->student;

        abort_if($assignment->section_id !== $student->section_id, 403);

        // prevent double submit
        $exists = AssignmentSubmission::where([
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
        ])->exists();

        if ($exists) {
            return back()->withErrors([
                'text' => 'You already submitted this assignment.',
            ]);
        }

        $request->validate([
            'text' => 'required|string|max:5000',
        ]);
        
        AssignmentSubmission::create([
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
            'answer_text' => $request->text,
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('dashboard.index')
            ->with('success', 'Assignment submitted successfully');
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
