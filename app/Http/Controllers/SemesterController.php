<?php

namespace App\Http\Controllers;

use App\Http\Requests\SemisterRequest;
use App\Models\Course;
use App\Models\Semester;
use App\Services\SemesterService;
use Inertia\Inertia;

class SemesterController extends Controller
{
    public function __construct(protected SemesterService $semesterService) {}

    public function index()
    {
        return Inertia::render('semester/Index', [
            'semesters' => $this->semesterService->getAll(),
        ]);
    }

    public function create()
    {
        return Inertia::render('semester/Create', [
            'courses' => Course::where('status', true)->get(),
        ]);
    }

    public function store(SemisterRequest $request)
    {
        $this->semesterService->create($request->validated());

        return redirect()->route('semesters.index');
    }

    public function edit(Semester $semester)
    {
        return Inertia::render('semester/Edit', [
            'semester' => $semester,
            'courses' => Course::where('status', true)->get(),
        ]);
    }

    public function update(SemisterRequest $request, Semester $semester)
    {
        $this->semesterService->update($semester, $request->validated());

        return redirect()->route('semesters.index');
    }

    public function destroy(Semester $semester)
    {
        $this->semesterService->delete($semester);

        return redirect()->back();
    }
}
