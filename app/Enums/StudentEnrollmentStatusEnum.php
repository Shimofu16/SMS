<?php

namespace App\Enums;

enum StudentEnrollmentStatusEnum: string
{
    case ACCEPTED = 'accepted';
    case PENDING = 'pending';
    case DECLINED = 'declined';

    public function getLabel(): string
    {
        return match ($this) {
            self::ACCEPTED => 'Accepted',
            self::PENDING => 'Pending',
            self::DECLINED => 'Declined',
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
