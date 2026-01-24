<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function storeOrUpdate(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $data = $request->validate([
            'designation' => 'required|string',
            'department' => 'required|string',
            'joining_date' => 'required|date',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|integer',
        ]);

        $user->teacher()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return back()->with('success', 'Teacher info saved');
    }
}
