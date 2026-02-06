<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Services\CourseService;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function __construct(private CourseService $courseService) {}

    /**
     * Display a listing of the courses.
     */
    public function index()
    {
        return Inertia::render('course/Index', [
            'courses' => $this->courseService->getAll(),
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
    public function store(CourseRequest $request)
    {
        $this->courseService->store($request->validated());

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
    public function update(CourseRequest $request, Course $course)
    {
        $this->courseService->update($course, $request->validated());

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        $this->courseService->delete($course);

        return redirect()
            ->back()
            ->with('success', 'Course deleted successfully');
    }
}
