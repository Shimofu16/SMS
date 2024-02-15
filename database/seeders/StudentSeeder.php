<?php

namespace Database\Seeders;

use App\Enums\EnrollmentStudentTypeEnum;
use App\Enums\FamilyMemberContactTypeEnum;
use App\Enums\StudentEnrollmentPaymentStatus;
use App\Enums\StudentEnrollmentStatusEnum;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentEnrollment;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $factory = Factory::create();
        $documents = [
            'birth_certificate' => $factory->imageUrl(),
            'form_138' => $factory->imageUrl(),
            'good_moral_certification' => $factory->imageUrl(),
            'photo' => $factory->imageUrl(),
        ];

        for ($i = 0; $i < 20; $i++) {
            $mop = $factory->randomElement(['cash', 'bank', 'g-cash']);
            $payments = [
                'mode_of_payment' => $mop, //cash, bank, g-cash
                'payment_method' => $factory->randomElement(['annual', 'semi-annual', 'quarterly', 'monthly']), //annual, semi-annual, quarterly, monthly
                'proof_of_payment' => ($mop == 'bank' || $mop == 'g-cash') ?  $factory->imageUrl() : '', // path of payment
                'amount' => $factory->randomFloat(2, 30000, 100000), //amount paid
                'status' => StudentEnrollmentPaymentStatus::PENDING->value //pending or paid
            ];
            $student_id =  Student::create([
                'lrn' => $factory->numberBetween(100000000, 999999999),
                'first_name' => $factory->firstName,
                'last_name' => $factory->lastName,
                'gender' => $factory->randomElement(['male', 'female']),
                'email' => $factory->safeEmail(),
                'birthday' => $factory->dateTimeBetween('-16 years', '-5 years'),
                'address' => $factory->address,
            ])->id;

            $student = Student::find($student_id);
            $grade_level_id = random_int(1, 12);
            $setting = getCurrentSetting();

            $department = '';
            if ($grade_level_id <= 6) {
                $department = 'Elementary';
            } else if ($grade_level_id <= 9) {
                $department = 'Junior High';
            } else {
                $department = 'Senior High';
            }

            $student->enrollments()->create([
                'grade_level_id' => $grade_level_id,
                'school_year_id' => $setting->school_year_id,
                'student_type' => EnrollmentStudentTypeEnum::NEW->value,
                'department' => $department,
                'documents' => $documents,
                'payments' => $payments,
                'status' => StudentEnrollmentStatusEnum::PENDING->value,
            ]);
            $relationships = ['father', 'mother', 'guardian'];
            foreach ($relationships as $relationship) {
                $student->familyMembers()->create([
                    'name' => $factory->name,
                    'birthday' => $factory->dateTimeBetween('-50 years', '-20 years'),
                    'phone' =>  $factory->phoneNumber,
                    'occupation' => $factory->jobTitle,
                    'relationship' => $relationship
                ]);
            }
        }
        // for ($i = 0; $i < 10; $i++) {
        //     $student_id =  Student::create([
        //         'lrn' => $factory->numberBetween(100000000, 999999999),
        //         'first_name' => $factory->firstName,
        //         'last_name' => $factory->lastName,
        //         'gender' => $factory->randomElement(['male', 'female']),
        //         'email' => $factory->safeEmail(),
        //         'birthday' => $factory->dateTimeBetween('-16 years', '-5 years'),
        //         'address' => $factory->address,
        //     ])->id;

        //     $student = Student::find($student_id);
        //     $grade_level_id = 1;
        //     $section_id = 1;
        //     $setting = getCurrentSetting();

        //     $department = 'Elementary';
        //     $mop = $factory->randomElement(['cash', 'bank', 'g-cash']);
        //     $payments = json_encode([
        //         'mode_of_payment' => $mop, //cash, bank, g-cash
        //         'payment_method' => $factory->randomElement(['annual', 'semi-annual', 'quarterly', 'monthly']), //annual, semi-annual, quarterly, monthly
        //         'proof_of_payment' => ($mop == 'bank' || $mop == 'g-cash') ?  $factory->imageUrl() : '', // path of payment
        //         'amount' => $factory->randomFloat(2, 30000, 100000), //amount paid
        //         'status' => StudentEnrollmentPaymentStatus::PAID->value //pending or paid
        //     ]);
        //     $student->enrollments()->create([
        //         'section_id' => $section_id,
        //         'grade_level_id' => $grade_level_id,
        //         'school_year_id' => $setting->school_year_id,
        //         'student_type' => EnrollmentStudentTypeEnum::NEW->value,
        //         'department' => $department,
        //         'documents' => json_decode($documents, true),
        //         'payments' => json_decode($payments, true),
        //         'status' => StudentEnrollmentStatusEnum::ACCEPTED->value,
        //     ]);
        //     $relationships = ['father', 'mother', 'guardian'];
        //     foreach ($relationships as $relationship) {
        //         $student->familyMembers()->create([
        //             'name' => $factory->name,
        //             'birthday' => $factory->dateTimeBetween('-50 years', '-20 years'),
        //             'phone' => $factory->phoneNumber,
        //             'occupation' => $factory->jobTitle,
        //             'relationship' => $relationship
        //         ]);
        //     }
        // }
    }
}
