<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\Section;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        // 🔒 security check: teacher owns this section
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
