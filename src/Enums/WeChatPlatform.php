<?php

namespace Papaedu\Extension\Enums;

final class WeChatPlatform
{
    public const OFFICIAL_ACCOUNT = 'official_account';

    public const APP = 'app';

    public const MINI_PROGRAM = 'mini_program';

    public static function transform(string $name)
    {
        if ($name === 'web' || $name === 'wap' || $name === 'mp') {
            return self::OFFICIAL_ACCOUNT;
        }
        if ($name === 'ios' || $name === 'android') {
            return self::APP;
        }
        if ($name === 'mini_program') {
            return self::MINI_PROGRAM;
        }

        return '';
    }
}
