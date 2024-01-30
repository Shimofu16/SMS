<?php

namespace App\Enums;

enum StudentEnrollmentPaymentStatus: string
{
    case PAID = 'paid';
    case PENDING = 'pending';
    case DECLINED = 'declined';

    public function getLabel(): string
    {
        return match ($this) {
            self::PAID => 'Paid',
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
