<?php

namespace App\Enums;

enum LevelEnum: string
{
    case PRESCHOOL_1 = 'preschool 1 (Play Group & Nursery)';
    case PRESCHOOL_2 = 'preschool 2 (Kindergarten)';
    case PRESCHOOL_3 = 'preschool 3  (Preparatory)';
    case ELEMENTARY_1 = 'elementary 1 (Grade 1 - 3)';
    case ELEMENTARY_2 = 'elementary 2 (Grade 4 - 6)';
    case JUNIOR_HIGHSCHOOL = 'junior highschool (Grade 7 - 10)';
    case SENIOR_HIGHSCHOOL = 'senior highschool (Grade 11 - 12)';

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->value;
        }
        return $array;
    }
}
