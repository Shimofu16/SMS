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
