<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CourseSeeder::class,
            SemesterSeeder::class,
            SectionSeeder::class,
            BulkUserSeeder::class,
            SectionTeacherSeeder::class,
            AssignSeeder::class,
            AssignmentSubmissionSeeder::class,
            AttendanceSeeder::class,
        ]);
    }
}
