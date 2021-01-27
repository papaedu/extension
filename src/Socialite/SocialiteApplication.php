<?php

namespace Papaedu\Extension\Socialite;

use Papaedu\Extension\Enums\WeChatPlatform;
use Papaedu\Extension\Http\Exceptions\SocialiteOfWeChatException;

class SocialiteApplication
{
    public static function wechat()
    {
        $platform = request()->header('platform');
        $channel = request()->header('channel');

        if ($platform && $channel) {
            if (WeChatPlatform::MINI_PROGRAM == $platform) {
                return new WeChatWithMiniProgram($platform, $channel);
            } else {
                return new WeChatWithOfficialAccount($platform, $channel);
            }
        }

        throw new SocialiteOfWeChatException('Init socialite of wechat error.');
    }
}
