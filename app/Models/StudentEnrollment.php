<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'grade_level_id',
        'section_id',
        'school_year_id',
        'student_type',
        'department',
        'documents',
        'payments',
        'status',
    ];

    // cast
    protected $casts = [
        'documents' => Json::class,
        'payments' => Json::class,
    ];



    // protected $appends = ['payment', 'document'];


    // public function getPaymentAttribute()
    // {
    //     return json_decode($this->attributes['payments'], true);
    // }

    // public function getDocumentAttribute()
    // {
    //     return json_decode($this->attributes['documents'], true);
    // }



    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year_id');
    }

    public function getArrayOfPayments($status)
    {
        $payments = [];
        foreach ($this->payments as $key => $value) {
            if ($key == 'status') {
                $payments[$key] = $status;
            } else {
                $payments[$key] = $value;
            }
        }
        return $payments;
    }

    public function hasDocument($document)
    {
        // dd($this->documents, $document);
        if ($this->documents[$document]) {
            return true;
        }
        return false;
    }
    
}
