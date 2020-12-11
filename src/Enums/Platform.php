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

        return 0;
    }
}
