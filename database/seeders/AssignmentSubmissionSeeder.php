<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assign;
use App\Models\Student;
use App\Models\AssignmentSubmission;
use Carbon\Carbon;

class AssignmentSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        $assignments = Assign::all();
        $students = Student::all();

        foreach ($assignments as $assignment) {
            // random students submit, some don’t (pending test)
            $submitStudents = $students->random(rand(3, min(7, $students->count())));

            foreach ($submitStudents as $student) {
                AssignmentSubmission::create([
                    'assignment_id' => $assignment->id,
                    'student_id' => $student->id,
                    'answer' => 'This is my assignment answer.',
                    'submitted_at' => Carbon::now()->subDays(rand(0, 5)),
                ]);
            }
        }
    }
}
