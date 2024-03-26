<?php

use App\Enums\EnrollmentStudentTypeEnum;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Enums\StudentEnrollmentStatusEnum;
use App\Models\StudentEnrollment;

if (!function_exists('getColor')) {
    function getColor($colors)
    {
        $stockColors = [
            '#1f77b4', // blue
            '#ff7f0e', // orange
            '#2ca02c', // green
            '#d62728', // red
            '#9467bd', // purple
            '#8c564b', // brown
            '#e377c2', // pink
            '#7f7f7f', // gray
            '#bcbd22', // yellow-green
            '#17becf', // cyan
            '#1a9850', // green
            '#66bd63', // green
            '#a6d96a', // green
            '#d9ef8b', // yellow-green
            '#fdae61', // orange
            '#f46d43', // orange
            '#d73027', // red
            '#a50026', // red
            '#ffeda0', // yellow
            '#737373', // gray
        ];

        $uniqueColors = [];

        // Iterate over each color in $colors
        foreach ($colors as $color) {
            // Check if the color exists in $stockColors and is not already added to $uniqueColors
            if (in_array($color, $stockColors) && !in_array($color, $uniqueColors)) {
                return $color; // Add the unique color to $uniqueColors
            }
        }
    }
}
if (!function_exists('generateSchoolId')) {
    function generateSchoolId($school_year)
    {
        $setting = getCurrentSetting();
        $year = explode('-', $school_year->slug)[0];
        $prefix = 'SCH'; // Example: Prefix 'SCH' for school

        // Generate a unique numerical value
        $studentCount = countStudentsWithStatus(StudentEnrollmentStatusEnum::ACCEPTED) + 1;
        $uniqueStudentCount =  Str::padLeft($studentCount, 5, '0');

        // Define the school ID format
        $schoolId = "{$year}-{$uniqueStudentCount}-{$prefix}-0";

        // Check if the generated school ID already exists
        $isSchoolIdExist = true;
        while ($isSchoolIdExist) {
            $isSchoolIdExist = Student::where('school_id', $schoolId)->exists();
            if ($isSchoolIdExist) {
                // Increment student count and regenerate school ID
                $studentCount++;
                $uniqueStudentCount =  Str::padLeft($studentCount, 5, '0');
                $schoolId = "{$year}-{$uniqueStudentCount}-{$prefix}-0";
            }
        }

        return $schoolId;
    }
}
if (!function_exists('getStudentTypes')) {
    function getStudentTypes($school_year)
    {
        $countPerType = [];
        foreach (EnrollmentStudentTypeEnum::toArray() as $key => $student_type) {
            $countPerType[] = (object)[
                'student_type' => $student_type,
                'count' => StudentEnrollment::where('school_year_id', $school_year->id)
                    ->where('status', StudentEnrollmentStatusEnum::PENDING->value)
                    ->where('student_type', $student_type)
                    ->count()
            ];
        }

        return (object)$countPerType;
    }
}
if (!function_exists('getDepartments')) {
    function getDepartments($school_year)
    {
        $departments = ['Elementary', 'Junior High', 'Senior High'];

        $countPerDepartment = [];
        foreach ($departments as $key => $department) {
            $countPerDepartment[] = (object)[
                'department' => $department,
                'count' => StudentEnrollment::where('school_year_id', $school_year->id)
                    ->where('status', StudentEnrollmentStatusEnum::PENDING->value)
                    ->where('department', $department)
                    ->count()
            ];
        }

        return (object)$countPerDepartment;
    }
}

if (!function_exists('getDepartment')) {
    function getDepartment($grade_level_id)
    {
        if ($grade_level_id <= 6) {
            return 'Elementary';
        } elseif ($grade_level_id <= 9) {
            return 'Junior High';
        } else {
            return 'Senior High';
        }
    }
}
