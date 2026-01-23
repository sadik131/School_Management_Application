<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\TeacherActivity;
use App\Models\StudentActivity;
use Spatie\Permission\Models\Role;


class BulkUserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('en_IN');

    // 🔐 Ensure roles exist
    Role::firstOrCreate(['name' => 'admin']);
    Role::firstOrCreate(['name' => 'teacher']);
    Role::firstOrCreate(['name' => 'student']);

    /**
     * =========================
     * 10 TEACHERS
     * =========================
     */
    for ($i = 1; $i <= 10; $i++) {

        $user = User::create([
            'name' => $faker->name,
            'email' => "teacher{$i}@school.com",
            'phone' => $faker->numerify('9#########'),
            'gender' => $faker->randomElement(['Male', 'Female']),
            'dob' => $faker->dateTimeBetween('-45 years', '-30 years'),
            'blood' => $faker->randomElement(['A+', 'B+', 'O+', 'AB+']),
            'address' => $faker->city . ', India',
            'role' => 'teacher',
            'password' => Hash::make('password'),
        ]);

        // 🔥 THIS FIXES YOUR ISSUE
        $user->assignRole('teacher');

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'teacher_id' => 'TCH-' . str_pad($i, 3, '0', STR_PAD_LEFT),
            'department' => 'Computer Applications',
            'designation' => $faker->randomElement([
                'Lecturer',
                'Assistant Professor'
            ]),
            'qualification' => 'MCA',
            'experience' => rand(2, 10) . ' Years',
        ]);

        TeacherActivity::create([
            'teacher_id' => $teacher->id,
            'total_assignments' => rand(20, 40),
            'checked_assignments' => rand(15, 30),
            'pending_assignments' => rand(1, 10),
            'total_classes' => rand(100, 160),
            'attendance_avg' => rand(75, 90) . '%',
            'eligible_students' => rand(40, 60),
            'detained_students' => rand(1, 8),
        ]);
    }

    /**
     * =========================
     * 20 STUDENTS (example)
     * =========================
     */
    for ($i = 1; $i <= 20; $i++) {

        $user = User::create([
            'name' => $faker->name,
            'email' => "student{$i}@school.com",
            'phone' => $faker->numerify('9#########'),
            'gender' => $faker->randomElement(['Male', 'Female']),
            'dob' => $faker->dateTimeBetween('-22 years', '-18 years'),
            'blood' => $faker->randomElement(['A+', 'B+', 'O+', 'AB+']),
            'address' => $faker->city . ', India',
            'role' => 'student',
            'password' => Hash::make('password'),
        ]);

        // 🔥 THIS FIXES YOUR ISSUE
        $user->assignRole('student');

        $student = Student::create([
            'user_id' => $user->id,
            'student_id' => 'STD-2023-' . str_pad($i, 3, '0', STR_PAD_LEFT),
            'course' => 'BCA',
            'section' => $faker->randomElement(['A', 'B']),
            'semester' => '5th',
            'roll_number' => 'BCA-5-' . $i,
        ]);

        StudentActivity::create([
            'student_id' => $student->id,
            'attendance_percentage' => rand(65, 90) . '%',
            'classes_attended' => rand(80, 120),
            'total_classes' => 130,
            'assignments_submitted' => rand(15, 25),
            'assignments_pending' => rand(0, 5),
            'assignments_late' => rand(0, 3),
            'exam_eligible' => true,
            'exam_detained' => false,
        ]);
    }
    }
}
