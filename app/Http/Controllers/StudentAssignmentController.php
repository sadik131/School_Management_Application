<?php

namespace App\Http\Controllers;

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

    return Inertia::render('Student/Index', [
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
        ],

        'student' => [
            'student_id' => $student->student_id,
            'roll'       => $student->roll_number,
            'course'     => $student->section->semester->course->code,
            'semester'   => $student->section->semester->name,
            'section'    => $student->section->name,
        ],

        // 🔹 dummy stats (for now)
        'stats' => [
            'attendance' => 78,
            'submitted'  => 11,
            'pending'    => 4,
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
