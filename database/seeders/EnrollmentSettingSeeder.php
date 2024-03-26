<?php

namespace Database\Seeders;

use App\Enums\GradingEnum;
use App\Models\EnrollmentSetting;
use App\Models\SchoolYear;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school_years = SchoolYear::all();
        foreach ($school_years as $key => $school_year) {
            if ($school_year->id ==  count($school_years)) {
                EnrollmentSetting::create([
                    'school_year_id' => $school_year->id,
                    'is_current' => true,
                ]);
            } else {
                EnrollmentSetting::create([
                    'school_year_id' => $school_year->id,
                    'current_grading' => GradingEnum::FOURTH->value,
                    'is_current' => false,
                ]);
            }
        }
    }
}
