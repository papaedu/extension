<?php

namespace Papaedu\Extension\Socialite;

use Papaedu\Extension\Enums\WeChatPlatform;
use Papaedu\Extension\Http\Exceptions\SocialiteOfWeChatException;

class SocialiteApplication
{
    protected static $loginWithWeChat;

    public static function wechat(string $platform = '', string $channel = '')
    {
        if (!$platform) {
            $platform = self::loginWithWeChat(WeChatWith::PLATFORM_KEY);
        }
        if (!$channel) {
            $channel = self::loginWithWeChat(WeChatWith::CHANNEL_KEY);
        }

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
