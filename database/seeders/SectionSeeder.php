<?php

namespace Database\Seeders;

use App\Models\GradeLevel;
use App\Models\Section;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $gradeLevels = GradeLevel::all();
        foreach ($gradeLevels as $gradeLevel) {
            for ($i = 0; $i < 2; $i++) {
                Section::create([
                    'name' => $faker->name,
                    'capacity' => 10,
                    'grade_level_id' => $gradeLevel->id,
                ]);
            }
        }
    }
}
