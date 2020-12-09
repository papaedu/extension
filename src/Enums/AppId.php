<?php

namespace Papaedu\Extension\Enums;

use BenSampo\Enum\Enum;

final class AppId extends Enum
{
    public const PAPA_EDU = 1;

    public const PAPA_IELTS = 2;

    public const PAPA_TOFEL = 3;

    public const PAPA_GMAT = 4;

    public const PAPA_GRE = 5;

    public const PAPA_TUTOR = 6;

    public static function getDescription($value): string
    {
        if ($value === self::PAPA_EDU) {
            return '趴趴英语';
        }
        if ($value === self::PAPA_IELTS) {
            return '趴趴英语雅思';
        }
        if ($value === self::PAPA_TOFEL) {
            return '趴趴英语托福';
        }
        if ($value === self::PAPA_GMAT) {
            return '趴趴英语GMAT';
        }
        if ($value === self::PAPA_GRE) {
            return '趴趴英语GRE';
        }
        if ($value === self::PAPA_TUTOR) {
            return '趴趴英语教师';
        }

        return parent::getDescription($value);
    }

    public static function transform(string $appName)
    {
        if ($appName === 'papaedu') {
            return self::PAPA_EDU;
        }
        if ($appName === 'papaielts') {
            return self::PAPA_IELTS;
        }
        if ($appName === 'papatofel') {
            return self::PAPA_TOFEL;
        }
        if ($appName === 'papagmat') {
            return self::PAPA_GMAT;
        }
        if ($appName === 'papagre') {
            return self::PAPA_GRE;
        }
        if ($appName === 'papatutor') {
            return self::PAPA_TUTOR;
        }

        return 0;
    }
}
