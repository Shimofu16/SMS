<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function settings()
    {
        return $this->hasMany(Setting::class, 'grade_level_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'grade_level_id');
    }

    public function studentEnrollments()
    {
        return $this->hasMany(StudentEnrollment::class, 'grade_level_id');
    }
}
