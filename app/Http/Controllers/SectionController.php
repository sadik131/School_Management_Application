<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectionController extends Controller
{
    public function index()
    {
        return Inertia::render('section/Index', [
            'sections' => Section::with('semester.course')
                ->latest()
                ->get(),
        ]);
    }

public function create()
{
    return Inertia::render('section/Create', [
        'courses' => Course::with('semesters')
            ->where('status', true)
            ->get(),
    ]);
}

    public function store(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'name'        => 'required|string|max:10',
            'capacity'    => 'nullable|integer|min:1',
            'status'      => 'boolean',
        ]);

        Section::create($request->only(
            'semester_id',
            'name',
            'capacity',
            'status'
        ));

        return redirect()->route('sections.index');
    }

    public function edit(Section $section)
{
    return Inertia::render('section/Edit', [
        'section'   => $section,
        'courses'   => Course::with('semesters')
            ->where('status', true)
            ->get(),
        'semesters' => Semester::with('course')
            ->where('status', true)
            ->get(),
    ]);
}


    public function update(Request $request, Section $section)
    {
        $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'name'        => 'required|string|max:10',
            'capacity'    => 'nullable|integer|min:1',
            'status'      => 'boolean',
        ]);

        $section->update($request->only(
            'semester_id',
            'name',
            'capacity',
            'status'
        ));

        return redirect()->route('sections.index');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->back();
    }
}
