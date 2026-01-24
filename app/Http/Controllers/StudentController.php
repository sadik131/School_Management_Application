<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function storeOrUpdate(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $data = $request->validate([
            'student_id'      => 'required|string|max:50',
            'roll_number'     => 'required|string|max:50',
            'section_id'      => 'required|integer',
            'program'         => 'required|string|max:100',
            'semester'        => 'required|integer|min:1|max:12',
            'admission_year'  => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $user->student()->updateOrCreate(
            ['user_id' => $user->id], // 🔑 FIX
            $data
        );

        return back()->with('success', 'Student academic info saved successfully');
    }
}
