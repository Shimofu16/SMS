<?php

namespace Database\Seeders;

use App\Models\SchoolYear;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school_year = SchoolYear::find(1);
        Setting::create([
            'school_year_id' => $school_year->id,
            'is_current' => true,
        ]);
    }
}
