<?php

use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Student;

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
        $school_year_id = SchoolYear::where('is_current', true)->first()->id;
        return Setting::where('school_year_id', $school_year_id)->first();
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


if (!function_exists('countWithStatus')) {
    /**
     * Get current setting.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function countWithStatus($status)
    {
        return  Student::with('enrollments')
            ->whereHas('enrollments', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->count();
    }
}
