<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();

        // last 15 days attendance
        for ($day = 0; $day < 15; $day++) {
            $date = Carbon::now()->subDays($day)->toDateString();

            foreach ($students as $student) {
                Attendance::create([
                    'student_id' => $student->id,
                    'section_id' => $student->section_id,
                    'date' => $date,
                    'status' => rand(1, 100) <= 80 ? 'present' : 'absent',
                ]);
            }
        }
    }
}
