<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMINISTRATOR = 'administrator';
    case REGISTRAR = 'registrar';
    case TEACHER = 'teacher';
    case STUDENT = 'student';


    public static function toArray($except = null)
    {
        $exceptValues = is_array($except) ? $except : ($except !== null ? [$except] : []);
        $array = [];

        foreach (self::cases() as $case) {
            if (!in_array($case->value, $exceptValues)) {
                $array[$case->value] = $case->value;
            }
        }

        return $array;
    }
}
