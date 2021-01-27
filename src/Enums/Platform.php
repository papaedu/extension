<?php

namespace Papaedu\Extension\Enums;

use BenSampo\Enum\Enum;

final class Platform extends Enum
{
    public const WEB = 1;

    public const H5 = 2;

    public const MP = 3;

    public const IOS = 4;

    public const ANDROID = 5;

    public const MINI_PROGRAM = 6;

    public const UNKNOWN = 99;

    public static function getDescription($value): string
    {
        if ($value === self::WEB) {
            return 'Web';
        }
        if ($value === self::H5) {
            return 'H5';
        }
        if ($value === self::MP) {
            return '微信公众号';
        }
        if ($value === self::IOS) {
            return '苹果';
        }
        if ($value === self::ANDROID) {
            return '安卓';
        }
        if ($value === self::MINI_PROGRAM) {
            return '小程序';
        }

        return parent::getDescription($value);
    }

    public static function transform(string $name)
    {
        if ($name === 'web') {
            return self::WEB;
        }
        if ($name === 'wap') {
            return self::H5;
        }
        if ($name === 'mp') {
            return self::MP;
        }
        if ($name === 'ios') {
            return self::IOS;
        }
        if ($name === 'android') {
            return self::ANDROID;
        }
        if ($name === 'mini_program') {
            return self::MINI_PROGRAM;
        }

        return self::UNKNOWN;
    }
}
