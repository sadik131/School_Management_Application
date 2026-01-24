<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index()
    {
        return Inertia::render('course/Index', [
            'courses' => Course::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        return Inertia::render('course/Create');
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'nullable|string|max:50',
            'status' => 'boolean',
        ]);

        Course::create([
            'name'   => $request->name,
            'code'   => $request->code,
            'status' => $request->status ?? true,
        ]);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course created successfully');
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        return Inertia::render('course/Edit', [
            'course' => $course,
        ]);
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'nullable|string|max:50',
            'status' => 'boolean',
        ]);

        $course->update([
            'name'   => $request->name,
            'code'   => $request->code,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->back()
            ->with('success', 'Course deleted successfully');
    }
}
