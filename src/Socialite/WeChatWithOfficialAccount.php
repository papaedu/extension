<?php

namespace Papaedu\Extension\Socialite;

use App\Enums\WeChatChannel;
use EasyWeChat;
use Papaedu\Extension\Http\Exceptions\WeChatUndefinedUnionIdException;

class WeChatWithOfficialAccount extends WeChatWith
{
    /**
     * Create application with platform.
     */
    protected function createApplication()
    {
        $configName = WeChatChannel::getConfigName($this->platform, $this->channel);
        $this->application = EasyWeChat::officialAccount($configName);
    }

    /**
     * Attempt to oauth the wechat by code.
     *
     * @param  string  $code
     */
    public function attemptOauth(string $code): void
    {
        $this->oauthUser = $this->application->oauth->userFromCode($code);
    }

    /**
     * Get oauth user union id when union id in information, else return oauth user openid.
     *
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\WeChatUndefinedUnionIdException
     */
    public function getId(): string
    {
        if (config('extension.socialite.channel.wechat.enable_union_id')) {
            return $this->getUnionId();
        } else {
            return $this->oauthUser->getId();
        }
    }

    /**
     * Get oauth user openid.
     *
     * @return string
     */
    public function getOpenid(): string
    {
        return $this->oauthUser->getId();
    }

    /**
     * Get oauth user union id.
     *
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\WeChatUndefinedUnionIdException
     */
    public function getUnionId(): string
    {
        if (!isset($this->oauthUser->getRaw()['unionid'])) {
            throw new WeChatUndefinedUnionIdException('Undefined union id.');
        }

        return $this->oauthUser->getRaw()['unionid'];
    }

    /**
     * Get oauth user nickname.
     *
     * @return string
     */
    public function getNickname(): string
    {
        return $this->oauthUser->getNickname();
    }

    /**
     * Get oauth user avatar.
     *
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->oauthUser->getAvatar();
    }
}
