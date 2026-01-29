<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class SectionTeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = Teacher::all();
        $sections = Section::all();

        foreach ($teachers as $teacher) {
            $assignSections = $sections->random(rand(1, 2));

            foreach ($assignSections as $section) {
                DB::table('section_teacher')->insertOrIgnore([
                    'teacher_id' => $teacher->id,
                    'section_id' => $section->id,
                ]);
            }
        }
    }
}
