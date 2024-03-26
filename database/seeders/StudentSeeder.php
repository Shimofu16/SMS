<?php

namespace Database\Seeders;

use App\Enums\EnrollmentStudentTypeEnum;
use App\Enums\FamilyMemberContactTypeEnum;
use App\Enums\StudentEnrollmentPaymentStatus;
use App\Enums\StudentEnrollmentStatusEnum;
use App\Models\GradeLevel;
use App\Models\SchoolYear;
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
        $school_years = SchoolYear::all();
        $documents = [
            'birth_certificate' => $factory->imageUrl(),
            'form_138' => $factory->imageUrl(),
            'good_moral_certification' => $factory->imageUrl(),
            'photo' => $factory->imageUrl(),
        ];

        foreach ($school_years as $school_year) {
            if ($school_year->id != count($school_years)) {
                $this->createNewStudents($factory, $school_year, $documents, StudentEnrollmentStatusEnum::ACCEPTED->value);
            }
        }

        foreach ($school_years as $school_year) {
            if ($school_year->id != 1) {
                $this->updateExistingStudents($school_year, $documents);
            }
        }

        $this->createNewStudents($factory, getCurrentSetting(), $documents, StudentEnrollmentStatusEnum::PENDING->value);
    }

    private function createNewStudents($factory, $school_year, $documents, $status)
    {
        for ($i = 0; $i < 20; $i++) {
            $grade_level = GradeLevel::find(random_int(1, GradeLevel::count()));
            $payments = [
                'total_amount' => getTotalAmountFee($grade_level->level),
                'total_balance' => getTotalAmountFee($grade_level->level) - random_int(getTotalAmountFee($grade_level->level) / 4, getTotalAmountFee($grade_level->level) / 2),
            ];
            $student =  Student::create([
                'school_id' => generateSchoolId($school_year),
                'lrn' => $factory->numberBetween(100000000, 999999999),
                'first_name' => $factory->firstName,
                'last_name' => $factory->lastName,
                'gender' => $factory->randomElement(['male', 'female']),
                'email' => $factory->safeEmail(),
                'birthday' => $factory->dateTimeBetween('-16 years', '-5 years'),
                'address' => $factory->address,
            ]);

            $department = getDepartment($grade_level->id);

            $student->enrollments()->create([
                'grade_level_id' => $grade_level->id,
                'school_year_id' => $school_year->id,
                'student_type' => EnrollmentStudentTypeEnum::NEW->value,
                'department' => $department,
                'documents' => $documents,
                'payments' => $payments,
                'status' => $status ,
            ]);

            $this->createFamilyMembers($factory, $student);
        }
    }

    private function updateExistingStudents($school_year, $documents)
    {
        $status = ($school_year->id == count(SchoolYear::all())) ? StudentEnrollmentStatusEnum::PENDING->value : StudentEnrollmentStatusEnum::ACCEPTED->value;

        $students = Student::with('enrollments')
            ->whereDoesntHave('enrollments', function ($query) use ($school_year) {
                $query->where('school_year_id', $school_year->id);
            })
            ->get();

        foreach ($students as $student) {
            // $grade_level_id = ($student->enrollment->grade_level_id + 1 >= 16) ? $student->enrollment->grade_level_id : $student->enrollment->grade_level_id + 1;
            $grade_level = GradeLevel::find($school_year->id);
            if ($grade_level->id < 16) {
                $enrollment = $student->enrollments()->where('school_year_id', $school_year->id - 1)->first();
                $recent_total_balance =  $enrollment->payments['total_balance'];
                $total_amount = getTotalAmountFee($grade_level->level);
                $total_balance = ($total_amount + $recent_total_balance) - random_int($total_amount / 4, $total_amount / 2);
                $payments = [
                    'total_amount' => getTotalAmountFee($grade_level->level),
                    'total_balance' => $total_balance,
                ];
                $student->enrollments()->create([
                    'grade_level_id' => $grade_level->id,
                    'school_year_id' => $school_year->id,
                    'student_type' => EnrollmentStudentTypeEnum::OLD_STUDENT->value,
                    'department' => getDepartment($grade_level->id),
                    'documents' => $documents,
                    'payments' =>  $payments,
                    'status' => $status,
                ]);
            }
        }
    }

    private function getDepartment($grade_level_id)
    {
        if ($grade_level_id <= 6) {
            return 'Elementary';
        } elseif ($grade_level_id <= 9) {
            return 'Junior High';
        } else {
            return 'Senior High';
        }
    }

    private function createFamilyMembers($factory, $student)
    {
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
}
