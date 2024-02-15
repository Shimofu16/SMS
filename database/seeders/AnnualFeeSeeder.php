<?php

namespace Database\Seeders;

use App\Enums\FeeTypeEnum;
use App\Enums\LevelEnum;
use App\Models\AnnualFee;
use App\Models\SchoolYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnualFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school_year = SchoolYear::find(1);
        /* Pre - School 1 (Play Group & Nursery) */
        $preschool_1 = [
            /* Pre - School 1 (Play Group & Nursery) */
            [
                'name' => 'Basic Tuition',
                'amount' => 12000,
                'type' => FeeTypeEnum::BASIC_TUITION->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Digital A/V ITCS',
                'amount' => 4000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Leaning Mgt. System',
                'amount' => 4500,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Library (Virtual) Dev',
                'amount' => 3000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Registration Fee',
                'amount' => 150,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Processing Fee',
                'amount' => 150,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Permanent Records',
                'amount' => 300,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'School ID',
                'amount' => 300,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Class Picture',
                'amount' => 100,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Insurance',
                'amount' => 800,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Maintenance & Utilities',
                'amount' => 2000,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Student Manual',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Manipulatives',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Learning Materials',
                'amount' => 1000,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Instructional Materials',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_1->value,
                'school_year_id' => $school_year->id,
            ],

        ];
        /* Pre - School 2 (Kindergarten) */
        $preschool_2 = [
            [
                'name' => 'Basic Tuition',
                'amount' => 12000,
                'type' => FeeTypeEnum::BASIC_TUITION->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Digital A/V ITCS',
                'amount' => 4000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Leaning Mgt. System',
                'amount' => 4500,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Library (Virtual) Dev',
                'amount' => 3000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Registration Fee',
                'amount' => 150,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Processing Fee',
                'amount' => 150,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Permanent Records',
                'amount' => 300,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'School ID',
                'amount' => 300,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Class Picture',
                'amount' => 100,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Insurance',
                'amount' => 800,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Maintenance & Utilities',
                'amount' => 2000,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Student Manual',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Manipulatives',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Learning Materials',
                'amount' => 1100,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],

            [
                'name' => 'Instructional Materials',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_2->value,
                'school_year_id' => $school_year->id,
            ],
        ];
        /* Pre - School 3 (Preparatory) */
        $preschool_3 = [
            [
                'name' => 'Basic Tuition',
                'amount' => 12000,
                'type' => FeeTypeEnum::BASIC_TUITION->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Digital A/V ITCS',
                'amount' => 4000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Leaning Mgt. System',
                'amount' => 4500,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Library (Virtual) Dev',
                'amount' => 3000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Registration Fee',
                'amount' => 150,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Processing Fee',
                'amount' => 150,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Permanent Records',
                'amount' => 300,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'School ID',
                'amount' => 300,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Class Picture',
                'amount' => 100,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Insurance',
                'amount' => 800,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Maintenance & Utilities',
                'amount' => 2000,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Student Manual',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Manipulatives',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Learning Materials',
                'amount' => 1100,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Instructional Materials',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::PRESCHOOL_3->value,
                'school_year_id' => $school_year->id,
            ],
        ];
        /* Elementary 1 (Grade 1 - 3) */
        $elementary_1 = [
            [
                'name' => 'Basic Tuition',
                'amount' => 11000,
                'type' => FeeTypeEnum::BASIC_TUITION->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Science Lab Dev Fee',
                'amount' => 1000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Computer Lab Dev Fee',
                'amount' => 1000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Digital A/V ITCS',
                'amount' => 3000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Leaning Mgt. System',
                'amount' => 3500,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Library (Virtual) Dev',
                'amount' => 3000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Registration Fee',
                'amount' => 150,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Processing Fee',
                'amount' => 150,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Permanent Records',
                'amount' => 300,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'School ID',
                'amount' => 300,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Class Picture',
                'amount' => 100,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Insurance',
                'amount' => 800,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Technology',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Maintenance & Utilities',
                'amount' => 2000,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Student Manual',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_1->value,
                'school_year_id' => $school_year->id,
            ],
        ];
        /* Elementary 1 (Grade 4 - 6) */
        $elementary_2 = [
            [
                'name' => 'Basic Tuition',
                'amount' => 11500,
                'type' => FeeTypeEnum::BASIC_TUITION->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Science Lab Dev Fee',
                'amount' => 1000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Computer Lab Dev Fee',
                'amount' => 1000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Digital A/V ITCS',
                'amount' => 3000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Leaning Mgt. System',
                'amount' => 3500,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Library (Virtual) Dev',
                'amount' => 3000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Registration Fee',
                'amount' => 150,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Processing Fee',
                'amount' => 150,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Permanent Records',
                'amount' => 300,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'School ID',
                'amount' => 300,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Class Picture',
                'amount' => 100,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Insurance',
                'amount' => 800,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Technology',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Maintenance & Utilities',
                'amount' => 2000,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Student Manual',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::ELEMENTARY_2->value,
                'school_year_id' => $school_year->id,
            ],
        ];
        /* JHS (Grade 7 - 10) */
        $jhs = [
            [
                'name' => 'Basic Tuition',
                'amount' => 11750,
                'type' => FeeTypeEnum::BASIC_TUITION->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Science Lab Dev Fee',
                'amount' => 1500,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Computer Lab Dev Fee',
                'amount' => 1500,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Digital A/V ITCS',
                'amount' => 2500,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Leaning Mgt. System',
                'amount' => 5000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Library (Virtual) Dev',
                'amount' => 3000,
                'type' => FeeTypeEnum::DEVELOPMENT_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Registration Fee',
                'amount' => 150,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Processing Fee',
                'amount' => 150,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Permanent Records',
                'amount' => 300,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'School ID',
                'amount' => 300,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Class Picture',
                'amount' => 100,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Insurance',
                'amount' => 800,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Technology',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Maintenance & Utilities',
                'amount' => 2000,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
            [
                'name' => 'Student Manual',
                'amount' => 500,
                'type' =>  FeeTypeEnum::MISCELLANEOUS_FEES->value,
                'level' => LevelEnum::JUNIOR_HIGHSCHOOL->value,
                'school_year_id' => $school_year->id,
            ],
        ];
        $data = array_merge(
            $preschool_1,
            $preschool_2,
            $preschool_3,
            $elementary_1,
            $elementary_2,
            $jhs
        );
        foreach ($data as $item) {
            AnnualFee::create($item);
        }
    }
}
