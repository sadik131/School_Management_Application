<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Course;
use App\Models\Section;
use App\Models\Semester;
use App\Services\SectionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectionController extends Controller
{
    public function __construct(protected SectionService $sectionService) {}

    public function index()
    {
        return Inertia::render('section/Index', [
            'sections' => $this->sectionService->getAll(),
        ]);
    }

    public function show($id)
    {
        return Inertia::render('studentList/Index', [
            'list' => Section::with(['students', 'students.user'])->findOrFail($id),
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

    public function store(SectionRequest $request)
    {

        $this->sectionService->create($request->validated());

        return redirect()->route('sections.index');
    }

    public function edit(Section $section)
    {
        return Inertia::render('section/Edit', [
            'section' => $section,
            'courses' => Course::with('semesters')
                ->where('status', true)
                ->get(),
            'semesters' => Semester::with('course')
                ->where('status', true)
                ->get(),
        ]);
    }

    public function update(Request $request, Section $section)
    {
        $this->sectionService->create($request->validated());

        return redirect()->route('sections.index');
    }

    public function destroy(Section $section)
    {
        $section->delete();

        return redirect()->back();
    }
}
