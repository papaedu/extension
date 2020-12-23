<?php

namespace Papaedu\Extension\Socialite;

use App\Enums\WeChatChannel;
use Papaedu\Extension\Enums\WeChatPlatform;
use Papaedu\Extension\Http\Exceptions\SocialiteOfWeChatException;

class SocialiteApplication
{
    protected static $loginWithWeChat;

    public static function wechat()
    {
        $platform = request()->header('platform', WeChatPlatform::MINI_PROGRAM);
        $channel = request()->header('channel', WeChatChannel::BEGIN_MINI_PROGRAM);

        if ($platform && $channel) {
            if (WeChatPlatform::OFFICIAL_ACCOUNT == $platform) {
                return new WeChatWithOfficialAccount($platform, $channel);
            } elseif (WeChatPlatform::MINI_PROGRAM == $platform) {
                return new WeChatWithMiniProgram($platform, $channel);
            }
        }

        throw new SocialiteOfWeChatException('Init socialite of wechat error.');
    }

    protected static function loginWithWeChat(string $key): string
    {
        if (!self::$loginWithWeChat) {
            self::$loginWithWeChat = session(WeChatWith::SESSION_NAME);
        }

        return self::$loginWithWeChat[$key] ?? '';
    }
}
