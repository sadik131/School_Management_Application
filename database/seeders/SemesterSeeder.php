<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $bca = Course::where('code', 'BCA')->first();

        foreach ([1,2,3,4,5,6] as $num) {
            Semester::create([
                'course_id' => $bca->id,
                'name' => $num . 'th Semester',
                'number' => $num,
                'status' => true,
            ]);
        }
    }
}
