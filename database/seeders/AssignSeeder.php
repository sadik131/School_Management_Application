<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assign;
use App\Models\Teacher;
use App\Models\Section;
use Faker\Factory as Faker;
use Carbon\Carbon;

class AssignSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('en_IN');
        $teachers = Teacher::all();
        $sections = Section::all();

        for ($i = 1; $i <= 15; $i++) {
            Assign::create([
                'teacher_id' => $teachers->random()->id,
                'section_id' => $sections->random()->id,
                'title' => 'Assignment ' . $i,
                'description' => $faker->sentence(10),
                // past + future date (AI overdue test)
                'due_date' => Carbon::now()->addDays(rand(-7, 10)),
            ]);
        }
    }
}
