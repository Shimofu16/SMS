<?php

namespace App\Models;

use App\Enums\StudentEnrollmentPaymentStatus;
use App\Enums\StudentEnrollmentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'teacher_id',
        'grade_level_id',
    ];

    protected $appends = ['students'];

    public function getStudentsAttribute()
    {
        $setting = getCurrentSetting();
        return $this->whereHas('studentEnrollments', function ($query) use ($setting) {
            $query->where('school_year_id', $setting->school_year_id)
                ->whereJsonContains('payments->status', StudentEnrollmentPaymentStatus::PAID->value)
                ->where('status', StudentEnrollmentStatusEnum::ACCEPTED->value);
        })
        ->with(['studentEnrollments' => function ($query) {
            $query->join('students', 'students.id', '=', 'student_enrollments.student_id')
                ->orderBy('students.gender', 'ASC');
        }])
        ->where('teacher_id', Auth::user()->teacher_id)
        ->get();

    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'section_id');
    }
    public function studentEnrollments()
    {
        return $this->hasMany(StudentEnrollment::class, 'section_id');
    }
}
