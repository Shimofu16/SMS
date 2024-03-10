<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kenepa\ResourceLock\Models\Concerns\HasLocks;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'birthday',
        'phone',
        'email',
        'address',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'teacher_id');
    }
    public function sections()
    {
        return $this->hasMany(Section::class, 'teacher_id');
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'teacher_id');
    }
}
