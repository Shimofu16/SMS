<?php

namespace App\Enums;

enum EnrollmentStudentTypeEnum: string
{
    case NEW = 'new';
    case TRANSFEREE = 'transferee';
    case OLD_STUDENT = 'old student';

    public function getLabel(): string
    {
        return match ($this) {
            self::NEW => 'New',
            self::TRANSFEREE => 'Transferee',
            self::OLD_STUDENT => 'Old Student',
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
