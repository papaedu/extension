<?php

namespace Papaedu\Extension\Enums;

use BenSampo\Enum\Enum;

final class AuthStatus extends Enum
{
    const Normal = 0;

    const IncompleteInformation = 11;

    const Disabled = 99;

    public static function getDescription($value): string
    {
        if ($value === self::Normal) {
            return '正常';
        }
        if ($value === self::IncompleteInformation) {
            return '未完善信息';
        }
        if ($value === self::Disabled) {
            return '已停用';
        }

        return parent::getDescription($value);
    }
}
