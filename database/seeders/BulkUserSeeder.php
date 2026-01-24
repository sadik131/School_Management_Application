<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\StudentActivity;
use App\Models\TeacherActivity;
use Spatie\Permission\Models\Role;

class BulkUserSeeder extends Seeder
{
    public function run(): void
    {
        $sections = Section::all();

        $faker = Faker::create('en_IN');

        // =========================
        // Ensure Roles
        // =========================
        $adminRole   = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // =========================
        // ADMIN USER
        // =========================
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('12345678'),
            ]
        );

        $admin->syncRoles(['admin']);

        // =========================
        // TEACHERS (5)
        // =========================
        for ($i = 1; $i <= 5; $i++) {

            $user = User::create([
                'name' => $faker->name,
                'email' => "teacher{$i}@school.com",
                'password' => Hash::make('password'),
            ]);

            $user->syncRoles(['teacher']);

            $teacher = Teacher::create([
                'user_id' => $user->id,
                'teacher_id' => 'TCH-' . rand(1000, 9999),
                'department' => 'BCA',
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
                'checked_assignments' => rand(10, 30),
                'pending_assignments' => rand(0, 10),
                'total_classes' => rand(80, 150),
                'attendance_avg' => rand(75, 90) . '%',
                'eligible_students' => rand(40, 60),
                'detained_students' => rand(0, 5),
            ]);
        }

        // =========================
        // STUDENTS (10)
        // =========================
        for ($i = 1; $i <= 10; $i++) {

            $user = User::create([
                'name' => $faker->name,
                'email' => "student{$i}@school.com",
                'password' => Hash::make('password'),
            ]);

            $user->syncRoles(['student']);

            $student = Student::create([
                'user_id' => $user->id,
                'student_id' => 'STD-' . now()->year . '-' . rand(1000, 9999),
                'roll_number' => 'BCA-' . rand(1, 99),
                'section_id' => $sections->random()->id,
            ]);

            StudentActivity::create([
                'student_id' => $student->id,
                'attendance_percentage' => rand(65, 90),
                'classes_attended' => rand(70, 120),
                'total_classes' => 130,
                'assignments_submitted' => rand(10, 25),
                'assignments_pending' => rand(0, 5),
                'assignments_late' => rand(0, 3),
                'exam_eligible' => true,
                'exam_detained' => false,
            ]);
        }
    }
}
