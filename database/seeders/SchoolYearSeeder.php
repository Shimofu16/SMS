<?php

namespace Database\Seeders;

use App\Models\SchoolYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school_years = [
            'slug' => '2021-2022',
            'start_date' => '2021-08-01',
            'end_date' => '2022-05-31',
            
        ];
        SchoolYear::create($school_years);
    }
}
