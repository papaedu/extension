<?php

namespace Papaedu\Extension\Enums;

use Papaedu\Extension\Enums\Traits\Label;

enum Platform: int
{
    use Label;

    case WEB = 1;

    case H5 = 2;

    case MP = 3;

    case IOS = 4;

    case ANDROID = 5;

    case MINI_PROGRAM = 6;

    case UNKNOWN = 99;

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::WEB => 'Web',
            self::H5 => 'H5',
            self::MP => '微信公众号',
            self::IOS => '苹果',
            self::ANDROID => '安卓',
            self::MINI_PROGRAM => '小程序',
            self::UNKNOWN => '未知',
        };
    }

    public static function getTransform(string $value): self
    {
        return match ($value) {
            'web' => self::WEB,
            'wap' => self::H5,
            'mp' => self::MP,
            'ios' => self::IOS,
            'android' => self::ANDROID,
            'mini_program' => self::MINI_PROGRAM,
            default => self::UNKNOWN,
        };
    }

    public static function isBindingDevice(self $value): bool
    {
        return in_array($value, [
            self::IOS,
            self::ANDROID,
        ]);
    }
}
