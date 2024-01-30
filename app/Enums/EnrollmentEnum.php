<?php

namespace App\Enums;

enum EnrollmentEnum: string
{
    case ACTIVE = 'active';
    case CLOSE = 'close';

    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::CLOSE => 'Close',
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
