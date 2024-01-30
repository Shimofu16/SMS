<?php

namespace Database\Seeders;

use App\Enums\LevelEnum;
use App\Models\GradeLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $grade_levels = [
            [
                'name' => 'Play Group',
                'slug' => 'play-group',
                'level' => LevelEnum::PRESCHOOL_1->value,
            ],
            [
                'name' => 'Nursery',
                'slug' => 'nursery',
                'level' => LevelEnum::PRESCHOOL_1->value,
            ],
            [
                'name' => 'Kindergarten',
                'slug' => 'kindergarten',
                'level' => LevelEnum::PRESCHOOL_2->value,
            ],
            [
                'name' => 'Preparatory',
                'slug' => 'preparatory',
                'level' => LevelEnum::PRESCHOOL_3->value,
            ],
            [
                'name' => 'Grade 1',
                'slug' => 'grade-1',
                'level' => LevelEnum::ELEMENTARY_1->value,
            ],
            [
                'name' => 'Grade 2',
                'slug' => 'grade-2',
                'level' => LevelEnum::ELEMENTARY_1->value,
            ],
            [
                'name' => 'Grade 3',
                'slug' => 'grade-3',
                'level' => LevelEnum::ELEMENTARY_1->value,
            ],
            [
                'name' => 'Grade 4',
                'slug' => 'grade-4',
                'level' => LevelEnum::ELEMENTARY_2->value,
            ],
            [
                'name' => 'Grade 5',
                'slug' => 'grade-5',
                'level' => LevelEnum::ELEMENTARY_2->value,
            ],
            [
                'name' => 'Grade 6',
                'slug' => 'grade-6',
                'level' => LevelEnum::ELEMENTARY_2->value,
            ],
            [
                'name' => 'Grade 7',
                'slug' => 'grade-7',
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
            ],
            [
                'name' => 'Grade 8',
                'slug' => 'grade-8',
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
            ],
            [
                'name' => 'Grade 9',
                'slug' => 'grade-9',
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
            ],
            [
                'name' => 'Grade 10',
                'slug' => 'grade-10',
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
            ],
            [
                'name' => 'Grade 11',
                'slug' => 'grade-11',
                'level' => LevelEnum::SENIOR_HIGHSCHOOL->value,
            ],
            [
                'name' => 'Grade 12',
                'slug' => 'grade-12',
                'level' => LevelEnum::SENIOR_HIGHSCHOOL->value,
            ],
        ];

        foreach ($grade_levels as $grade_level) {
            GradeLevel::create($grade_level);
        }
    }
}
