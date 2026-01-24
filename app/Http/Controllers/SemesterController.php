<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SemesterController extends Controller
{
    public function index()
    {
        return Inertia::render('semester/Index', [
            'semesters' => Semester::with('course')
                ->latest()
                ->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('semester/Create', [
            'courses' => Course::where('status', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'number'    => 'required|integer|min:1',
            'name'      => 'required|string|max:255',
            'status'    => 'boolean',
        ]);

        Semester::create($request->only(
            'course_id',
            'number',
            'name',
            'status'
        ));

        return redirect()->route('semesters.index');
    }

    public function edit(Semester $semester)
    {
        return Inertia::render('semester/Edit', [
            'semester' => $semester,
            'courses'  => Course::where('status', true)->get(),
        ]);
    }

    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'number'    => 'required|integer|min:1',
            'name'      => 'required|string|max:255',
            'status'    => 'boolean',
        ]);

        $semester->update($request->only(
            'course_id',
            'number',
            'name',
            'status'
        ));

        return redirect()->route('semesters.index');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();

        return redirect()->back();
    }
}
