<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kenepa\ResourceLock\Models\Concerns\HasLocks;

class SchoolYear extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slug',
        'start_date',
        'end_date',
        'is_current',
    ];

    protected $cast = [
        'is_current' => 'boolean'
    ];

    public function settings()
    {
        return $this->hasMany(EnrollmentSetting::class, 'school_year_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'school_year_id');
    }

    public function studentEnrollments()
    {
        return $this->hasMany(StudentEnrollment::class, 'school_year_id');
    }

    public function annualFees()
    {
        return $this->hasMany(AnnualFee::class, 'school_year_id');
    }



}
