<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'name' => 'BCA',
            'code' => 'BCA',
            'status' => true,
        ]);

        Course::create([
            'name' => 'BSc Computer Science',
            'code' => 'BSC-CS',
            'status' => true,
        ]);
    }
}
