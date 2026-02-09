<?php

namespace App\AI;

use App\Models\Assign;
use App\Models\AssignmentSubmission;
use App\Models\Attendance;

class TeacherBrain
{
    public static function answer(string $question, $user): string
    {
        $q = strtolower(trim($question));
        $teacher = $user->teacher ?? null;

        if (!$teacher) {
            return "❌ <b>Teacher profile not found.</b>";
        }

        // My assignments
        if (str_contains($q, 'my assignment')) {
            $total = Assign::where('teacher_id', $teacher->id)->count();

            return "📝 <b>My Assignments</b><br>
            ━━━━━━━━━━━━━━━━━━<br>
            Total Assignments : {$total}";
        }

        // Pending submissions (who didn’t submit)
        if (str_contains($q, 'who') || str_contains($q, 'submit')) {
            $pending = AssignmentSubmission::whereHas('assignment', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })->count();

            return "❌ <b>Pending Submissions</b><br>
            ━━━━━━━━━━━━━━━━━━<br>
            Pending Submissions : {$pending}";
        }

        // Attendance summary (teacher’s sections)
        if (str_contains($q, 'attendance')) {
            $records = Attendance::whereIn(
                'section_id',
                $teacher->sections->pluck('id')
            );

            $total = $records->count();
            $present = $records->where('status', 'present')->count();
            $percent = $total > 0 ? round(($present / $total) * 100) : 0;

            return "📊 <b>Section Attendance</b><br>
            ━━━━━━━━━━━━━━━━━━<br>
            Attendance : {$percent}%";
        }

        return "👩‍🏫 <b>Teacher AI</b><br>
        ━━━━━━━━━━━━━━━━━━<br>
        You can ask:<br>
        • my assignments<br>
        • who didn’t submit<br>
        • section attendance";
    }
}
