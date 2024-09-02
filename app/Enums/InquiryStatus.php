<?php

namespace App\Enums;

enum InquiryStatus
{
    const Unanswered = 0;
    const Answered = 1;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Unanswered:
                return '未解決';
            case self::Answered:
                return '解決済み';
            default:
                return self::getKey($value);
        }
    }
}
