<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user()->load('teacher');

        return Inertia::render('profile/Index', [
            'role' => $user->roles->pluck('name'),
            'profile' => [
                'basic' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'gender' => $user->gender,
                    'dob' => $user->dob,
                    'blood' => $user->blood,
                    'address' => $user->address,
                ],
                'academic' => $user->teacher ? [
                    'designation' => $user->teacher->designation,
                    'department' => $user->teacher->department,
                    'qualification' => $user->teacher->qualification,
                    'experience' => $user->teacher->experience,
                ] : null,
            ],
        ]);
    }


    public function updateBasic(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'nullable|string|max:20',
            'gender'  => 'nullable|in:Male,Female',
            'dob'     => 'nullable|date',
            'blood'   => 'nullable|string|max:5',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($data);

        return back()->with('success', 'Profile updated successfully');
    }

}
