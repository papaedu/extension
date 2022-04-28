<?php

namespace Papaedu\Extension\Enums;

use Papaedu\Extension\Enums\Traits\Label;

enum AuthStatus: int
{
    use Label;

    case NORMAL = 0;

    case INCOMPLETE_INFORMATION = 11;

    case BANED = 98;

    case CLOSED = 99;

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::NORMAL => '正常',
            self::INCOMPLETE_INFORMATION => '未完善信息',
            self::BANED => '封停账号',
            self::CLOSED => '注销账号',
        };
    }

    public static function isDisable(self $value): bool
    {
        return in_array($value, [
            self::BANED,
            self::CLOSED,
        ]);
    }
}
