<?php

namespace App\Enums;

enum DocumentTypeEnum: string
{
    case PHOTO = 'photo';
    case FORM_138 = 'form_138';
    case BIRTH_CERTIFICATE = 'birth_certificate';
    case  GOOD_MORAL_CERTIFICATION = 'good_moral_certification';

    public function getLabel(): string
    {
        return match ($this) {
            self::PHOTO => 'photo',
            self::FORM_138 => 'form_138',
            self::BIRTH_CERTIFICATE => 'birth_certificate',
            self::GOOD_MORAL_CERTIFICATION => 'good_moral_certification',
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
