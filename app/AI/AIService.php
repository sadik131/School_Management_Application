<?php

namespace App\AI;

use Illuminate\Support\Facades\Auth;
use App\AI\AdminBrain;
use App\AI\TeacherBrain;
use App\AI\StudentBrain;

class AIService
{
    public static function ask(string $question): string
    {
        $user = Auth::user();

        if (!$user) {
            return "❌ <b>Unauthorized</b><br>Please login first.";
        }

        // 🔐 STRICT ROLE-BASED ROUTING
        if ($user->hasRole('admin')) {
            return AdminBrain::answer($question, $user);
        }

        if ($user->hasRole('teacher')) {
            return TeacherBrain::answer($question, $user);
        }

        if ($user->hasRole('student')) {
            return StudentBrain::answer($question, $user);
        }

        return "❌ <b>Access Denied</b>";
    }
}
