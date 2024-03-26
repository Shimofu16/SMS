<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends  Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar',
        'name',
        'email',
        'email_verified_at',
        'status',
        'password',
        'is_force_to_password_change',
        'student_id',
        'teacher_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }


   

    // public function canAccessPanel($panel): bool
    // {
    //     if ($panel->getId() === 'admin') {
    //         return $this->hasRole('administrator') && $this->hasVerifiedEmail();
    //     }
    //     if ($panel->getId() === 'registrar') {
    //         return $this->hasRole('administrator') || ($this->hasRole('registrar') && $this->hasVerifiedEmail());
    //     }
    //     if ($panel->getId() === 'teacher') {
    //         return  $this->hasRole('teacher') && $this->hasVerifiedEmail();
    //     }
    //     if ($panel->getId() === 'student') {
    //         return  $this->hasRole('student') && $this->hasVerifiedEmail();
    //     }

    //     return false;
    // }
}
