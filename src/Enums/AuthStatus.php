<?php

namespace Papaedu\Extension\Enums;

use BenSampo\Enum\Enum;

final class AuthStatus extends Enum
{
    const Normal = 0;

    const IncompleteInformation = 11;

    const Ban = 98;

    const Disable = 99;

    public static function getDescription($value): string
    {
        if ($value === self::Normal) {
            return '正常';
        }
        if ($value === self::IncompleteInformation) {
            return '未完善信息';
        }
        if ($value === self::Ban) {
            return '禁用';
        }
        if ($value === self::Disable) {
            return '停用';
        }

        return parent::getDescription($value);
    }

    public static function isDisable($value)
    {
        return in_array($value, [
            self::Ban,
            self::Disable,
        ]);
    }
}
