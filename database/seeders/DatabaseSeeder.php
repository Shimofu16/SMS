<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SubjectSeeder::class,
            SchoolYearSeeder::class,
            EnrollmentSettingSeeder::class,
            GradeLevelSeeder::class,
            AnnualFeeSeeder::class,
            TeacherSeeder::class,
            SectionSeeder::class,
            StudentSeeder::class,
            UserSeeder::class,
        ]);
    }
}
