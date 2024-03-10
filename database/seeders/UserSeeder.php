<?php

namespace Database\Seeders;

use App\Enums\StudentEnrollmentPaymentStatus;
use App\Enums\StudentEnrollmentStatusEnum;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'manage-settings'],
            ['name' => 'add-setting'],
            ['name' => 'edit-setting'],
            
            ['name' => 'manage-teachers'],
            ['name' => 'add-teacher'],
            ['name' => 'edit-teacher'],
            ['name' => 'delete-teacher'],
            
            ['name' => 'manage-sections'],
            ['name' => 'add-section'],
            ['name' => 'edit-section'],
            ['name' => 'delete-section'],
            
            ['name' => 'manage-subjects'],
            ['name' => 'add-subject'],
            ['name' => 'edit-subject'],
            ['name' => 'delete-subject'],
            
            ['name' => 'manage-fees'],
            ['name' => 'add-fee'],
            ['name' => 'edit-fee'],
            ['name' => 'delete-fee'],
            
            // ['name' => 'manage-fees'],
            // ['name' => 'add-fee'],
            // ['name' => 'edit-fee'],
            // ['name' => 'delete-fee'],

        ];

        foreach ($permissions as $key => $permission) {
            Permission::create($permission);
        }

        $administrator = Role::create(['name' => 'administrator']);
        $registrar = Role::create(['name' => 'registrar']);
        $teacher = Role::create(['name' => 'teacher']);
        $student = Role::create(['name' => 'student']);
        
        
        $setting = getCurrentSetting();
        $teach = Teacher::find(1);
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
                'name' => $teach->name,
                'email' => $teach->email,
                'teacher_id' => $teach->id,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ],
        ];
        foreach ($users as $key => $user) {
            $user =  User::create($user);
        }
    }
}
