<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->with([
                'roles',
                'student.section',
                'student.activity',
                'teacher.sections.semester.course',
                'teacher.activity',
                'teacher.assignments',
            ])

            // 🔍 Name / Email search
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })

            // 🎭 Role filter
            ->when($request->role, function ($query, $role) {
                $query->whereHas('roles', function ($q) use ($role) {
                    $q->where('name', $role);
                });
            })

            // 🚦 Status filter
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })

            ->latest()
            ->paginate(50)
            ->withQueryString();

        return Inertia::render('users/Index', [
            'users' => $users,
            'filters' => $request->only(['search', 'role', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('users/Create', [
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'roles' => 'required|array',
        ]);

        // 🔐 password hash
        $data['password'] = Hash::make($data['password']);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        // ✅ role assign (multiple supported)
        $user->syncRoles($data['roles']);

        return redirect()
            ->route('users.index')
            ->with('success', 'User added successfully');
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
        $user = User::with([
            'roles',
            'teacher.sections.semester.course',
            'student.activity',
            'student.section',
        ])->findOrFail($id);

        return Inertia::render('users/Edit', [
            'user' => $user,
            'roles' => Role::all(),
            'sections' => Section::with('semester.course')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable',
            'role' => 'array',
        ]);

        // basic info update
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // password only if given
        if (! empty($data['password'])) {
            $user->update([
                'password' => bcrypt($data['password']),
            ]);
        }

        // role update
        if (isset($data['role'])) {
            $user->syncRoles($data['role']);
        }

        return redirect()->route('users.index');
    }

    public function storeOrUpdateTeacher(Request $request, User $user)
    {
        $validated = $request->validate([
            'teacher_id'   => 'required|integer',
            'department' => 'required|string',
            'designation' => 'required|string',
            'qualification' => 'required|string',
            'experience' => 'required|string',
            'sections' => ['required', 'array'],
            'sections.*' => ['integer', 'exists:sections,id'],
        ]);
        // 🔎 create or get teacher
        $teacher = Teacher::updateOrCreate(
            ['user_id' => $user->id],
            [
                'teacher_id'   => $validated['teacher_id'],
                'department' => $validated['department'],
                'designation' => $validated['designation'],
                'qualification' => $validated['qualification'],
                'experience' => $validated['experience'],
            ]
        );

        // 🔗 sync sections
        $teacher->sections()->sync($validated['sections']);

        return back()->with('success', 'Teacher info saved successfully');
        }
        
    public function storeOrUpdateStudent(Request $request, User $user)
    {
        $data = $request->validate([
            'student_id' => 'required|string',
            'section_id' => 'required|exists:sections,id',
            'admission_year' => 'required|integer',
            'roll_number' => 'required|integer|min:1',
        ]);
        $section = Section::with('semester.course')->findOrFail($data['section_id']);
        $course = $section->semester->course;

        Student::updateOrCreate(
            ['user_id' => $user->id],
            [
                'student_id' => $data['student_id'],
                'section_id' => $section->id,
                'admission_year' => $data['admission_year'],

                // ✅ admin provided roll number
                'roll_number' => $data['roll_number'],

                // auto-filled
                'program' => $course->code ?: $course->name,
                'semester' => $section->semester->number,
            ]
        );

        return back()->with('success', 'Student assigned successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user)
    {
        $user = User::findOrFail($user);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'user is deleted');
    }
}
