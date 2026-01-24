<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $semesters = Semester::all();

        foreach ($semesters as $semester) {
            foreach (['A', 'B', 'C'] as $sectionName) {
                Section::create([
                    'semester_id' => $semester->id,
                    'name' => $sectionName,
                    'capacity' => 40,
                    'status' => true,
                ]);
            }
        }
    }
}
