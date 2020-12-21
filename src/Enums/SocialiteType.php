<?php

namespace Papaedu\Extension\Enums;

final class SocialiteType
{
    public const WECHAT_UNION_ID = 10;

    public static function transform(string $platform, string $channel): int
    {
        switch ($channel) {
            case 'union':
                $type = self::WECHAT_UNION_ID;
                break;
            default:
                $type = 0;
        }

        return $type;
    }
}
