<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'Mother Tongue'],
            ['name' => 'Filipino'],
            ['name' => 'English'],
            ['name' => 'Science'],
            ['name' => 'Mathematics'],
            ['name' => 'Araling Panglipunan'],
            ['name' => 'EPP/TLE'],
            ['name' => 'MAPEH'],
            ['name' => 'Edukasyon sa Pagpapakatao'],
            ['name' => 'Christian Living Education'],
        ];
        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
