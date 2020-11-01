<?php

namespace Papaedu\Extension\Enums;

final class SocialiteType
{
    const WeChatUnionId = 10;

    const WeChatMeetYouMP = 11;

    public static function transform(string $channel)
    {
        switch ($channel) {
            case 'union':
                $type = self::WeChatUnionId;
                break;
            case 'meetyoump':
                $type = self::WeChatMeetYouMP;
                break;
            default:
                $type = 0;
        }

        return $type;
    }

    public static function union()
    {
        return [
            self::WeChatUnionId,
        ];
    }
}
