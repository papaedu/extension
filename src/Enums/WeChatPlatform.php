<?php

namespace Papaedu\Extension\Enums;

enum WeChatPlatform: string
{
    case OFFICIAL_ACCOUNT = 'official_account';

    case APP = 'app';

    case MINI_PROGRAM = 'mini_program';

    case UNKNOWN = '';

    public static function getTransform(string $name): self
    {
        return match ($name) {
            'web', 'wap', 'mp' => self::OFFICIAL_ACCOUNT,
            'ios', 'android' => self::APP,
            'mini_program' => self::MINI_PROGRAM,
            default => self::UNKNOWN,
        };
    }
}
