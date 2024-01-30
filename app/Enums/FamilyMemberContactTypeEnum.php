<?php

namespace App\Enums;

enum FamilyMemberContactTypeEnum: string
{
    case PHONE = 'phone';
    case EMAIL = 'email';
    case LANDLINE = 'landline';

    public function getLabel(): string
    {
        return match ($this) {
            self::PHONE => 'Phone',
            self::EMAIL => 'Email',
            self::LANDLINE => 'Landline',
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
