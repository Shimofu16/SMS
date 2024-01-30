<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name',
        'birthday',
        'phone',
        'address',
        'occupation',
        'relationship',
    ];

    // cast
    protected $casts = [
        'birthday' => 'date',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
