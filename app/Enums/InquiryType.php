<?php

namespace App\Enums;

enum InquiryType
{
    const PrivacyPolicy = 0;
    const AboutUs = 1;
    const Other = 2;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::PrivacyPolicy:
                return 'プライバシーポリシーについて';
            case self::AboutUs:
                return '運営者について';
            case self::Other:
                return 'その他';
            default:
                return self::getKey($value);
        }
    }
}
