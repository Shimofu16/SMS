<?php

namespace App\Enums;

enum FeeTypeEnum: string
{
        /* First, Second, Third, Fourth */
    case BASIC_TUITION = 'basic tuition';
    case DEVELOPMENT_FEES = 'development fees';
    case MISCELLANEOUS_FEES = 'miscellaneous fees';

    public function getLabel(): string
    {
        return match ($this) {
            self::BASIC_TUITION => 'Basic Tuition',
            self::DEVELOPMENT_FEES => 'Development Fees',
            self::MISCELLANEOUS_FEES => 'Miscellaneous Fees',
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
