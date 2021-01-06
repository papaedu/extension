<?php

namespace Papaedu\Extension\Socialite;

use App\Enums\WeChatChannel;
use EasyWeChat;
use Overtrue\Socialite\Exceptions\AuthorizeFailedException;
use Papaedu\Extension\Enums\BadRequestCode;
use Papaedu\Extension\Http\Exceptions\WeChatUndefinedUnionIdException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WeChatWithMiniProgram extends WeChatWith
{
    /**
     * Create application with platform.
     */
    protected function createApplication()
    {
        $configName = WeChatChannel::getConfigName($this->platform, $this->channel);
        $this->application = EasyWeChat::miniProgram($configName);
    }

    /**
     * Attempt to oauth the wechat by code.
     *
     * @param  string  $code
     * @throws \Overtrue\Socialite\Exceptions\AuthorizeFailedException
     */
    public function attemptOauth(string $code): void
    {
        $this->oauthUser = $this->application->auth->session($code);
        if (isset($this->oauthUser['errcode'])) {
            throw new AuthorizeFailedException(json_encode($this->oauthUser, JSON_UNESCAPED_UNICODE), $this->oauthUser);
        }
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
            return $this->oauthUser['openid'];
        }
    }

    /**
     * Get oauth user openid.
     *
     * @return string
     */
    public function getOpenid(): string
    {
        return $this->oauthUser['openid'];
    }

    /**
     * @return string
     */
    public function getSessionKey(): string
    {
        return $this->oauthUser['session_key'];
    }

    /**
     * Get oauth user union id.
     *
     * @return string
     */
    public function getUnionIdWithCode(): string
    {
        return $this->oauthUser['unionid'] ?? '';
    }

    /**
     * Get oauth user union id.
     *
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\WeChatUndefinedUnionIdException
     */
    public function getUnionId(): string
    {
        if (!isset($this->oauthUser['userInfo']['unionId'])) {
            $this->saveOauthUser();

            throw new WeChatUndefinedUnionIdException('Undefined union id.');
        }

        return $this->oauthUser['userInfo']['unionId'];
    }

    /**
     * Get oauth user nickname.
     *
     * @return string
     */
    public function getNickname(): string
    {
        return '';
    }

    /**
     * Get oauth user avatar.
     *
     * @return string
     */
    public function getAvatar(): string
    {
        return '';
    }

    /**
     * @param  string  $sessionKey
     * @param  string  $iv
     * @param  string  $encryptedData
     * @return array
     */
    public function decryptData(string $sessionKey, string $iv, string $encryptedData): array
    {
        try {
            return $this->application->encryptor->decryptData($sessionKey, $iv, $encryptedData);
        } catch (EasyWeChat\Kernel\Exceptions\DecryptException $e) {
            throw new HttpException(
                400,
                trans('extension::socialite.miss_authorization_info'),
                null,
                [],
                BadRequestCode::SOCIALITE_MISS_SESSION_KEY
            );
        }
    }
}
