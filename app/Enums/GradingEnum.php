<?php

namespace App\Enums;

enum GradingEnum: string
{
        /* First, Second, Third, Fourth */
    case FIRST = 'first';
    case SECOND = 'second';
    case THIRD = 'third';
    case FOURTH = 'fourth';

    public function getLabel(): string
    {
        return match ($this) {
            self::FIRST => 'First',
            self::SECOND => 'Second',
            self::THIRD => 'Third',
            self::FOURTH => 'Fourth',
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
