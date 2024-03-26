<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ['name' => 'view-dashboard'],

            ['name' => 'view-academics'],

            ['name' => 'view-settings'],

            ['name' => 'view-enrollment-settings'],
            ['name' => 'add-enrollment-setting'],
            ['name' => 'edit-enrollment-setting'],
            ['name' => 'delete-enrollment-setting'],

            ['name' => 'view-teachers'],
            ['name' => 'add-teacher'],
            ['name' => 'edit-teacher'],
            ['name' => 'delete-teacher'],

            ['name' => 'view-sections'],
            ['name' => 'add-section'],
            ['name' => 'edit-section'],
            ['name' => 'delete-section'],

            ['name' => 'view-subjects'],
            ['name' => 'add-subject'],
            ['name' => 'edit-subject'],
            ['name' => 'delete-subject'],

            ['name' => 'view-schedules'],
            ['name' => 'add-schedule'],
            ['name' => 'edit-schedule'],
            ['name' => 'delete-schedule'],

            ['name' => 'view-school-years'],
            ['name' => 'add-school-year'],
            ['name' => 'edit-school-year'],
            ['name' => 'delete-school-year'],

            ['name' => 'view-payments'],
            ['name' => 'view-fees'],
            ['name' => 'add-fee'],
            ['name' => 'edit-fee'],
            ['name' => 'delete-fee'],

            ['name' => 'view-transactions'],
            ['name' => 'add-transaction'],
            ['name' => 'edit-transaction'],
            ['name' => 'delete-transaction'],

            ['name' => 'view-announcements'],
            ['name' => 'add-announcement'],
            ['name' => 'edit-announcement'],
            ['name' => 'delete-announcement'],

            ['name' => 'view-students'],
            ['name' => 'view-enrolled-students'],
            ['name' => 'add-enrolled-student'],
            ['name' => 'edit-enrolled-student'],
            ['name' => 'delete-enrolled-student'],

            ['name' => 'view-enrollee-students'],
            ['name' => 'add-enrollee-student'],
            ['name' => 'edit-enrollee-student'],
            ['name' => 'delete-enrollee-student'],

            ['name' => 'view-grades'],
            ['name' => 'add-grade'],
            ['name' => 'edit-grade'],
            ['name' => 'delete-grade'],

            ['name' => 'view-access-controls'],
            ['name' => 'view-users'],
            ['name' => 'add-user'],
            ['name' => 'edit-user'],
            ['name' => 'delete-user'],
            // ['name' => 'add-fee'],
            // ['name' => 'edit-fee'],
            // ['name' => 'delete-fee'],

        ];

        foreach ($permissions as $key => $permission) {
            Permission::create($permission);
        }

        $administrator = Role::create(['name' => 'administrator']);
        $administrator->givePermissionTo('view-dashboard');

        $administrator->givePermissionTo('view-settings');

        $administrator->givePermissionTo('view-enrollment-settings');
        $administrator->givePermissionTo('add-enrollment-setting');
        $administrator->givePermissionTo('edit-enrollment-setting');
        $administrator->givePermissionTo('delete-enrollment-setting');

        $administrator->givePermissionTo('view-teachers');
        $administrator->givePermissionTo('add-teacher');
        $administrator->givePermissionTo('edit-teacher');
        $administrator->givePermissionTo('delete-teacher');

        $administrator->givePermissionTo('view-sections');
        $administrator->givePermissionTo('add-section');
        $administrator->givePermissionTo('edit-section');
        $administrator->givePermissionTo('delete-section');

        $administrator->givePermissionTo('view-subjects');
        $administrator->givePermissionTo('add-subject');
        $administrator->givePermissionTo('edit-subject');
        $administrator->givePermissionTo('delete-subject');

        $administrator->givePermissionTo('view-schedules');
        $administrator->givePermissionTo('add-schedule');
        $administrator->givePermissionTo('edit-schedule');
        $administrator->givePermissionTo('delete-schedule');

        $administrator->givePermissionTo('view-school-years');
        $administrator->givePermissionTo('add-school-year');
        $administrator->givePermissionTo('edit-school-year');
        $administrator->givePermissionTo('delete-school-year');

        $administrator->givePermissionTo('view-payments');
        $administrator->givePermissionTo('view-fees');
        $administrator->givePermissionTo('add-fee');
        $administrator->givePermissionTo('edit-fee');
        $administrator->givePermissionTo('delete-fee');

        $administrator->givePermissionTo('view-transactions');
        $administrator->givePermissionTo('add-transaction');
        $administrator->givePermissionTo('edit-transaction');
        $administrator->givePermissionTo('delete-transaction');

        $administrator->givePermissionTo('view-announcements');
        $administrator->givePermissionTo('add-announcement');
        $administrator->givePermissionTo('edit-announcement');
        $administrator->givePermissionTo('delete-announcement');

        $administrator->givePermissionTo('view-students');
        $administrator->givePermissionTo('view-enrolled-students');
        $administrator->givePermissionTo('add-enrolled-student');
        $administrator->givePermissionTo('edit-enrolled-student');
        $administrator->givePermissionTo('delete-enrolled-student');

        $administrator->givePermissionTo('view-enrollee-students');
        $administrator->givePermissionTo('add-enrollee-student');
        $administrator->givePermissionTo('edit-enrollee-student');
        $administrator->givePermissionTo('delete-enrollee-student');

        $administrator->givePermissionTo('view-grades');
        $administrator->givePermissionTo('add-grade');
        $administrator->givePermissionTo('edit-grade');
        $administrator->givePermissionTo('delete-grade');

        $administrator->givePermissionTo('view-access-controls');
        $administrator->givePermissionTo('view-users');
        $administrator->givePermissionTo('add-user');
        $administrator->givePermissionTo('edit-user');
        $administrator->givePermissionTo('delete-user');

        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@app.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        $user->assignRole($administrator);
        $user = User::create([
            'name' => 'Dev Roy',
            'email' => 'royjosephlatayan16@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        $user->assignRole($administrator);

        $registrar = Role::create(['name' => 'registrar']);
        $registrar->givePermissionTo('view-dashboard');

        $user = User::create([
            'name' => 'Registrar',
            'email' => 'registrar@app.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        $user->assignRole($registrar);

        $teacher = Role::create(['name' => 'teacher']);
        $teacher->givePermissionTo('view-dashboard');
        $teach = Teacher::find(1);

        $user = User::create([
            'name' => $teach->name,
            'email' => $teach->email,
            'teacher_id' => $teach->id,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        $user->assignRole($teacher);

        $student = Role::create(['name' => 'student']);
        $student->givePermissionTo('view-dashboard');
        $student->givePermissionTo('view-grades');
        $student->givePermissionTo('view-schedules');
    }
}
