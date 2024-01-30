<?php

namespace Database\Seeders;

use App\Enums\StudentEnrollmentPaymentStatus;
use App\Enums\StudentEnrollmentStatusEnum;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'administrator',
            ],
            [
                'name' => 'Registrar',
                'slug' => 'registrar',
            ],
            [
                'name' => 'Teacher',
                'slug' => 'teacher',
            ],
            [
                'name' => 'Student',
                'slug' => 'student',
            ],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }
        $setting = getCurrentSetting();
        $teacher = Teacher::find(1);
        $student = Student::with('enrollments')
            ->whereHas('enrollments', function ($query) use ($setting) {
                $query
                    ->where('school_year_id', $setting->school_year_id)
                    ->whereJsonContains('payments->status', StudentEnrollmentPaymentStatus::PAID->value)
                    ->where('status', StudentEnrollmentStatusEnum::ACCEPTED->value);
            })
            ->first();
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@app.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Registrar',
                'email' => 'registrar@app.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ],
            [
                'name' => $teacher->name,
                'email' => $teacher->email,
                'teacher_id' => $teacher->id,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ],
            [
                'name' => $student->full_name,
                'email' => $student->email,
                'student_id' => $student->id,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ],
        ];
        foreach ($users as $key => $user) {
            $user =  User::create($user);
            $user->assignRole($key + 1);
        }
    }
}
