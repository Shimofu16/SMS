<?php

use App\Models\AnnualFee;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\EnrollmentSetting;
use App\Models\Student;
use App\Models\StudentGrade;

if (!function_exists('getCurrentSetting')) {
    /**
     * Get current setting.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function getCurrentSetting()
    {
        return EnrollmentSetting::where('is_current', true)->first();
    }
}

if (!function_exists('getSectionWithCapacityNotFull')) {
    /**
     * Get current setting.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function getSectionWithCapacityNotFull($grade_level_id)
    {
        $max_iterations = 10; // Set a maximum number of iterations to prevent infinite loops
        $current_iteration = 0;
        $section_id = null;

        do {
            $section = Section::query()
                ->withCount('studentEnrollments as students_count')
                ->where('grade_level_id', $grade_level_id);

            if ($section_id) {
                $section = $section->where('id', '!=', $section_id);
            }

            $section = $section->first();

            if (!$section || $section->students_count < $section->capacity) {
                return $section;
            }

            $section_id = $section->id;
            $current_iteration++;
        } while ($current_iteration < $max_iterations);

        // If no section found within the maximum iterations, return null
        return null;
    }
}


if (!function_exists('countStudentsWithStatus')) {
    /**
     * Get current setting.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function countStudentsWithStatus($status)
    {
        return  Student::with('enrollments')
            ->whereHas('enrollments', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->count();
    }
}
if (!function_exists('countWithSchoolYear')) {
    /**
     * Count the Students with status and school year.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function countStudentsWithStatusAndSchoolYear($status, $school_year_id)
    {
        return  Student::with('enrollments')
            ->whereHas('enrollments', function ($query) use ($status, $school_year_id) {
                $query
                    ->where('school_year_id', $school_year_id)
                    ->where('status', $status);
            })
            ->count();
    }
}
if (!function_exists('getStudentsWith')) {
    /**
     * Count the Students with status and school year.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function getStudentsWith($status, $school_year_id = null)
    {
        return  Student::with('enrollments')
            ->whereHas('enrollments', function ($query) use ($school_year_id, $status) {
                $query
                    ->where('status', $status);
                if ($school_year_id) {
                    $query
                        ->where('school_year_id', $school_year_id);
                }
            })
            ->get();
    }
}
if (!function_exists('getStudentsQueryWith')) {
    /**
     * Count the Students with status and school year.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function getStudentsQueryWith($status, $school_year_id = null)
    {
        return Student::query()
            ->with('enrollments')
            ->whereHas('enrollments', function ($query) use ($school_year_id, $status) {
                $query
                    ->where('status', $status);
                if ($school_year_id) {
                    $query
                        ->where('school_year_id', $school_year_id);
                }
            })
            ->get();
    }
}
if (!function_exists('isAllStudentsHasGrades')) {
    /**
     * Get current setting.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function isAllStudentsHasGrades()
    {
        $isALlHasGrades = false;
        $setting = getCurrentSetting();
        $students = Student::all();
        foreach ($students as $key => $student) {
            switch ($setting->current_grading) {
                case 'first':
                    $grade = $student->grades()
                        ->where('grade_level_id', $student->enrollment->grade_level_id)
                        ->where('school_year_id', $setting->school_year_id)
                        ->whereJsonContains('grades->first', 0) //grades - first not equal 0
                        ->first();
                    break;
                case 'second':
                    $grade = $student->grades()
                        ->where('grade_level_id', $student->enrollment->grade_level_id)
                        ->where('school_year_id', $setting->school_year_id)
                        ->whereJsonContains('grades->second', 0) //grades - first not equal 0
                        ->first();
                    break;
                case 'third':
                    $grade = $student->grades()
                        ->where('grade_level_id', $student->enrollment->grade_level_id)
                        ->where('school_year_id', $setting->school_year_id)
                        ->whereJsonContains('grades->third', 0) //grades - first not equal 0
                        ->first();
                    break;
                case 'fourth':
                    $grade = $student->grades()
                        ->where('grade_level_id', $student->enrollment->grade_level_id)
                        ->where('school_year_id', $setting->school_year_id)
                        ->whereJsonContains('grades->fourth', 0) //grades - first not equal 0
                        ->first();
                    break;
            }
            $grade = $student->grades()
                ->where('grade_level_id', $student->enrollment->grade_level_id)
                ->where('school_year_id', $setting->school_year_id)
                ->whereJsonContains('grades->first', 0) //grades - first not equal 0
                ->first();
            if ($grade) {
                $isALlHasGrades = true;
            }
        }
        return $isALlHasGrades;
    }
}
if (!function_exists('getTotalAmountFee')) {
    /**
     * Get current setting.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function getTotalAmountFee($level, $school_year_id = null)
    {
        $query = AnnualFee::where('level', $level);

        if ($school_year_id !== null) {
            $query->where('school_year_id', $school_year_id);
        }

        $amount = $query->sum('amount');

        return $amount;
    }
}
if (!function_exists('getTheStudentBalanceBy')) {
    /**
     * Get current setting.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function getTheStudentBalanceBy($student, $school_year_id)
    {
        $student = Student::with('enrollments')
        ->whereHas('enrollments', function($query) use ($school_year_id) {
            $query->where('school_year_id', $school_year_id);
        })
        ->first();

        

        return $amount;
    }
}
