<?php

namespace Papaedu\Extension\Enums;

use BenSampo\Enum\Enum;

final class AuthStatus extends Enum
{
    public const NORMAL = 0;

    public const INCOMPLETE_INFORMATION = 11;

    public const BANED = 98;

    public const CLOSED = 99;

    public static function getDescription($value): string
    {
        if ($value === self::NORMAL) {
            return '正常';
        }
        if ($value === self::INCOMPLETE_INFORMATION) {
            return '未完善信息';
        }
        if ($value === self::BANED) {
            return '封停账号';
        }
        if ($value === self::CLOSED) {
            return '注销账号';
        }

        return parent::getDescription($value);
    }

    public static function isDisable($value): bool
    {
        return in_array($value, [
            self::BANED,
            self::CLOSED,
        ]);
    }
}
