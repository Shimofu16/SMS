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
            ['subject' => 'Mother Tongue'],
            ['subject' => 'Filipino'],
            ['subject' => 'English'],
            ['subject' => 'Science'],
            ['subject' => 'Mathematics'],
            ['subject' => 'Araling Panglipunan'],
            ['subject' => 'EPP/TLE'],
            ['subject' => 'MAPEH'],
            ['subject' => 'Edukasyon sa Pagpapakatao'],
            ['subject' => 'Christian Living Education'],
        ];
        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
