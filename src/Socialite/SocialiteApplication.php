<?php

namespace Papaedu\Extension\Socialite;

use Papaedu\Extension\Enums\Header;
use Papaedu\Extension\Enums\WeChatPlatform;
use Papaedu\Extension\Http\Exceptions\SocialiteOfWeChatException;

class SocialiteApplication
{
    public static function wechat()
    {
        $platform = request()->header(Header::PLATFORM);
        $channel = request()->header(Header::CHANNEL);

        if ($platform && $channel) {
            $weChatPlatform = WeChatPlatform::transform($platform);
            if (WeChatPlatform::MINI_PROGRAM == $weChatPlatform) {
                return new WeChatWithMiniProgram($platform, $channel);
            } else {
                return new WeChatWithOfficialAccount($platform, $channel);
            }
        }

        throw new SocialiteOfWeChatException('Init socialite of wechat error.');
    }
}
