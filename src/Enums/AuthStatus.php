<?php

namespace Papaedu\Extension\Enums;

use BenSampo\Enum\Enum;

final class AuthStatus extends Enum
{
    const NORMAL = 0;

    const INCOMPLETE_INFORMATION = 11;

    const BAN = 98;

    const CLOSE = 99;

    public static function getDescription($value): string
    {
        if ($value === self::NORMAL) {
            return '正常';
        }
        if ($value === self::INCOMPLETE_INFORMATION) {
            return '未完善信息';
        }
        if ($value === self::BAN) {
            return '封停账号';
        }
        if ($value === self::CLOSE) {
            return '注销账号';
        }

        return parent::getDescription($value);
    }

    public static function isDisable($value)
    {
        return in_array($value, [
            self::BAN,
            self::CLOSE,
        ]);
    }
}
