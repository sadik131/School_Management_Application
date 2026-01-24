<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user()->load('student');

        return Inertia::render('profile/StudentProfile', [
            'profile' => [
                'basic' => [
                    'name'    => $user->name,
                    'email'   => $user->email,
                    'phone'   => $user->phone,
                    'gender'  => $user->gender,
                    'dob'     => $user->dob,
                    'blood'   => $user->blood,
                    'address' => $user->address,
                ],

                'academic' => $user->student ? [
                    // virtual student id
                    'studentId'  => 'STD-' . $user->id,
                    'course'     => $user->student->program,
                    'section'    => optional($user->student->section)->name ?? 'N/A',
                    'semester'   => $user->student->semester,
                    'rollNumber' => $user->student->student_id,
                ] : null,

                'activity' => [
                    'attendance' => [
                        'percentage'      => '78%',
                        'classesAttended' => 94,
                        'totalClasses'    => 120,
                    ],
                    'assignments' => [
                        'submitted' => 18,
                        'pending'   => 4,
                        'late'      => 2,
                    ],
                    'examStatus' => [
                        'eligible' => true,
                        'detained' => false,
                    ],
                ],
            ],
        ]);
    }

    public function updateBasic(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150|unique:users,email,' . $user->id,
            'phone'   => 'nullable|string|max:20',
            'gender'  => 'nullable|in:Male,Female',
            'dob'     => 'nullable|date|before:today',
            'blood'   => 'nullable|string|max:5',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($data);

        return back()->with('success', 'Profile updated successfully');
    }

}
