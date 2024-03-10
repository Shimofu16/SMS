<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kenepa\ResourceLock\Models\Concerns\HasLocks;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'lrn',
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'gender',
        'email',
        'birthday',
        'address',
    ];

    protected $casts = [
        'birthday' => 'date'
    ];

    protected $appends = ['full_name', 'age', 'enrollment', 'father', 'mother', 'guardian', 'photo_url'];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name} {$this->ext_name}";
    }

    public function getAgeAttribute()
    {
        return $this->birthday->age;
    }

    public function getEnrollmentAttribute()
    {
        $setting = getCurrentSetting();
        return $this->enrollments()
            ->where('school_year_id', $setting->school_year_id)
            ->first();
    }

    public function getFatherAttribute()
    {
        return $this->familyMembers()
            ->where('relationship', 'Father')
            ->first();
    }
    public function getMotherAttribute()
    {
        return $this->familyMembers()
            ->where('relationship', 'Mother')
            ->first();
    }

    public function getGuardianAttribute()
    {
        return $this->familyMembers()
            ->where('relationship', 'Guardian')
            ->first();
    }

    public function getPhotoUrlAttribute()
    {
        return $this->enrollment->documents['photo'];
    }


    public function user()
    {
        return $this->hasOne(User::class, 'student_id');
    }

    public function enrollments()
    {
        return $this->hasMany(StudentEnrollment::class, 'student_id');
    }
    public function grades()
    {
        return $this->hasMany(StudentGrade::class, 'student_id');
    }
    public function familyMembers()
    {
        return $this->hasMany(StudentFamilyMember::class, 'student_id');
    }
}
