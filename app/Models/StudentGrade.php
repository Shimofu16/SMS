<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kenepa\ResourceLock\Models\Concerns\HasLocks;

class StudentGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'student_id',
        'grade_level_id',
        'school_year_id',
        'grades',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'grades' => Json::class,
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year_id');
    }
}
