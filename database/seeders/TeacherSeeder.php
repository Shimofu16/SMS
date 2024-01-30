<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $teachers = [
            [
                'name' => $faker->name,
                'birthday' => $faker->dateTimeBetween('-50 years', 'now')->format('Y-m-d'),
                'phone' => $faker->phoneNumber,
                'email' => 'teacher@app.com',
                'address' => $faker->address,
            ],
            [
                'name' => $faker->name,
                'birthday' => $faker->dateTimeBetween('-50 years', 'now')->format('Y-m-d'),
                'phone' => $faker->phoneNumber,
                'email' => $faker->safeEmail,
                'address' => $faker->address,
            ],
            [
                'name' => $faker->name,
                'birthday' => $faker->dateTimeBetween('-50 years', 'now')->format('Y-m-d'),
                'phone' => $faker->phoneNumber,
                'email' => $faker->safeEmail,
                'address' => $faker->address,
            ],
            [
                'name' => $faker->name,
                'birthday' => $faker->dateTimeBetween('-50 years', 'now')->format('Y-m-d'),
                'phone' => $faker->phoneNumber,
                'email' => $faker->safeEmail,
                'address' => $faker->address,
            ],
            [
                'name' => $faker->name,
                'birthday' => $faker->dateTimeBetween('-50 years', 'now')->format('Y-m-d'),
                'phone' => $faker->phoneNumber,
                'email' => $faker->safeEmail,
                'address' => $faker->address,
            ],
            [
                'name' => $faker->name,
                'birthday' => $faker->dateTimeBetween('-50 years', 'now')->format('Y-m-d'),
                'phone' => $faker->phoneNumber,
                'email' => $faker->safeEmail,
                'address' => $faker->address,
            ],
            [
                'name' => $faker->name,
                'birthday' => $faker->dateTimeBetween('-50 years', 'now')->format('Y-m-d'),
                'phone' => $faker->phoneNumber,
                'email' => $faker->safeEmail,
                'address' => $faker->address,
            ],
            [
                'name' => $faker->name,
                'birthday' => $faker->dateTimeBetween('-50 years', 'now')->format('Y-m-d'),
                'phone' => $faker->phoneNumber,
                'email' => $faker->safeEmail,
                'address' => $faker->address,
            ],
            [
                'name' => $faker->name,
                'birthday' => $faker->dateTimeBetween('-50 years', 'now')->format('Y-m-d'),
                'phone' => $faker->phoneNumber,
                'email' => $faker->safeEmail,
                'address' => $faker->address,
            ],
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }

    }
}
