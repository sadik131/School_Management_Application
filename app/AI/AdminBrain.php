<?php

namespace App\AI;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Section;
use App\Models\Assign;
use App\Models\AssignmentSubmission;
use App\Models\Attendance;
use Carbon\Carbon;

class AdminBrain
{
    public static function answer(string $question, $user): string
    {
        $q = strtolower(trim($question));

        // FULL SYSTEM OVERVIEW
        if (str_contains($q, 'dashboard') || str_contains($q, 'summary') || str_contains($q, 'overview')) {
            return self::dashboard();
        }

        // USER STATS
        if (str_contains($q, 'user')) {
            return self::users();
        }

        // ACADEMIC STRUCTURE
        if (str_contains($q, 'course') || str_contains($q, 'semester') || str_contains($q, 'section')) {
            return self::academics();
        }

        // ASSIGNMENTS
        if (str_contains($q, 'assignment')) {
            return self::assignments();
        }

        // ATTENDANCE
        if (str_contains($q, 'attendance')) {
            return self::attendance();
        }

        return self::help();
    }

    /* ================= DASHBOARD ================= */

    private static function dashboard(): string
    {
        return "📊 <b>Admin Dashboard Overview</b><br>
        ━━━━━━━━━━━━━━━━━━<br>
        👥 Users : " . User::count() . "<br>
        👨‍🎓 Students : " . Student::count() . "<br>
        👩‍🏫 Teachers : " . Teacher::count() . "<br><br>

        🏫 Courses : " . Course::count() . "<br>
        📘 Semesters : " . Semester::count() . "<br>
        🏫 Sections : " . Section::count() . "<br><br>

        📝 Assignments : " . Assign::count() . "<br>
        📥 Submissions : " . AssignmentSubmission::count() . "<br>
        ⏰ Overdue : " . Assign::whereDate('due_date', '<', now())->count() . "<br><br>

        📊 Attendance Records : " . Attendance::count();
    }

    /* ================= USERS ================= */

    private static function users(): string
    {
        return "👥 <b>User Statistics</b><br>
        ━━━━━━━━━━━━━━━━━━<br>
        Total Users : " . User::count() . "<br>
        Students : " . Student::count() . "<br>
        Teachers : " . Teacher::count();
    }

    /* ================= ACADEMICS ================= */

    private static function academics(): string
    {
        return "🏫 <b>Academic Structure</b><br>
        ━━━━━━━━━━━━━━━━━━<br>
        Courses : " . Course::count() . "<br>
        Semesters : " . Semester::count() . "<br>
        Sections : " . Section::count();
    }

    /* ================= ASSIGNMENTS ================= */

    private static function assignments(): string
    {
        return "📝 <b>Assignment Overview</b><br>
        ━━━━━━━━━━━━━━━━━━<br>
        Total Assignments : " . Assign::count() . "<br>
        Submissions : " . AssignmentSubmission::count() . "<br>
        Pending : " . (Assign::count() - AssignmentSubmission::distinct('assignment_id')->count()) . "<br>
        Overdue : " . Assign::whereDate('due_date', '<', now())->count();
    }

    /* ================= ATTENDANCE ================= */

    private static function attendance(): string
    {
        $total = Attendance::count();
        $present = Attendance::where('status', 'present')->count();
        $percent = $total > 0 ? round(($present / $total) * 100) : 0;

        return "📊 <b>Attendance Summary</b><br>
        ━━━━━━━━━━━━━━━━━━<br>
        Records : {$total}<br>
        Present : {$percent}%<br>
        Absent : " . (100 - $percent) . "%";
    }

    /* ================= HELP ================= */

    private static function help(): string
    {
        return "⚙️ <b>Admin AI Help</b><br>
        ━━━━━━━━━━━━━━━━━━<br>
        Try asking:<br>
        • dashboard summary<br>
        • user statistics<br>
        • academic structure<br>
        • assignment overview<br>
        • attendance summary";
    }
}
