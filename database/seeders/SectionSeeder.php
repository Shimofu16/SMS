<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Section;
use App\Models\GradeLevel;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
                    'name' => Str::ucfirst(Str::substr($gradeLevel->name, 0, 1)) . ' Section ' . $i + 1,
                    'capacity' => 10,
                    'grade_level_id' => $gradeLevel->id,
                ]);
            }
        }
    }
}
