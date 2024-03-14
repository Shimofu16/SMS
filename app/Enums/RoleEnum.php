<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case REGISTRAR = 'registrar';
    case TEACHER = 'teacher';
    case STUDENT = 'student';

    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::REGISTRAR => 'Registrar',
            self::TEACHER => 'Teacher',
            self::STUDENT => 'Student',
        };
    }

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->value;
        }
        return $array;
    }
}
