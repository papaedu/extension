<?php

namespace Papaedu\Extension\Enums;

use BenSampo\Enum\Enum;

final class AuthStatus extends Enum
{
    const Normal = 0;

    const IncompleteInformation = 11;

    const Ban = 98;

    const Close = 99;

    public static function getDescription($value): string
    {
        if ($value === self::Normal) {
            return '正常';
        }
        if ($value === self::IncompleteInformation) {
            return '未完善信息';
        }
        if ($value === self::Ban) {
            return '封停账号';
        }
        if ($value === self::Close) {
            return '注销账号';
        }

        return parent::getDescription($value);
    }

    public static function isDisable($value)
    {
        return in_array($value, [
            self::Ban,
            self::Close,
        ]);
    }
}
