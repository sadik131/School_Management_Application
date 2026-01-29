<?php

namespace App\AI;

use App\Models\Assign;
use App\Models\Attendance;

class StudentBrain
{
    public static function answer(string $question, $user): string
    {
        $q = strtolower(trim($question));
        $student = $user->student ?? null;

        if (!$student) {
            return "❌ <b>Student profile not found.</b>";
        }

        // 🔹 Pending assignments
        if (str_contains($q, 'pending')) {
            $pending = Assign::where('section_id', $student->section_id)
                ->whereDoesntHave('submissions', function ($q) use ($student) {
                    $q->where('student_id', $student->id);
                })
                ->count();

            return "📚 <b>My Pending Assignments</b><br>
            ━━━━━━━━━━━━━━━━━━<br>
            &nbsp;&nbsp;Pending : {$pending}";
        }

        // 🔹 My attendance
        if (str_contains($q, 'attendance')) {
            $total = Attendance::where('student_id', $student->id)->count();
            $present = Attendance::where('student_id', $student->id)
                ->where('status', 'present')
                ->count();

            $percent = $total > 0 ? round(($present / $total) * 100) : 0;

            return "👨‍🎓 <b>My Attendance</b><br>
            ━━━━━━━━━━━━━━━━━━<br>
            &nbsp;&nbsp;Present : {$present}<br>
            &nbsp;&nbsp;Absent : " . ($total - $present) . "<br>
            &nbsp;&nbsp;Percentage : {$percent}%";
        }

        // ❌ Anything else
        return "❌ <b>Access Limited</b><br>
        You can ask about:<br>
        • my pending assignments<br>
        • my attendance";
    }
}
