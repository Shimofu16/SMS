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
        $schoolYears = [
            [
                'slug' => '2021-2022',
                'start_date' => '2021-08-01',
                'end_date' => '2022-05-31',
            ],
            [
                'slug' => '2022-2023',
                'start_date' => '2022-08-01',
                'end_date' => '2023-05-31',
            ],
            [
                'slug' => '2023-2024',
                'start_date' => '2023-08-01',
                'end_date' => '2024-05-31',
            ],
        ];

        foreach ($schoolYears as $year) {
            SchoolYear::create($year);
        }
    }
}
