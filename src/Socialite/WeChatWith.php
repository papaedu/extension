<?php

namespace Papaedu\Extension\Socialite;

use Papaedu\Extension\Http\Exceptions\SocialiteOfWeChatException;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class WeChatWith implements WeChatInterface
{
    const SESSION_NAME = 'login_with_wechat';

    const OAUTH_USER_KEY = 'oauth_user';

    const PLATFORM_KEY = 'platform';

    const CHANNEL_KEY = 'channel';

    /**
     * @var \Overtrue\Socialite\User|array
     */
    protected $oauthUser;

    /**
     * @var string
     */
    protected string $platform;

    /**
     * @var string
     */
    protected string $channel;

    protected $application;

    public function __construct(string $platform, string $channel)
    {
        $this->platform = $platform;
        $this->channel = $channel;
        $this->createApplication();
    }

    /**
     * Create application with platform.
     */
    abstract protected function createApplication();

    /**
     * @param  string  $key
     * @return array|string
     */
    public function getSession(string $key = '')
    {
        $sessions = session(self::SESSION_NAME);

        if ($key) {
            return $sessions[$key] ?? '';
        }

        return $sessions;
    }

    /**
     * @param  string  $sessionKey
     * @param  string  $iv
     * @param  string  $encryptedData
     * @return array
     */
    public function decryptData(string $sessionKey, string $iv, string $encryptedData): array
    {
        throw new HttpException(500, trans('extension::status_message.500.default'));
    }

    /**
     * Get oauth user by session.
     *
     * @return array
     * @throws \Papaedu\Extension\Http\Exceptions\SocialiteOfWeChatException
     */
    public function loadOauthUserBySession()
    {
        $session = $this->getSession();

        if (!isset($session[self::PLATFORM_KEY]) && $this->platform != $session[self::PLATFORM_KEY]) {
            throw new SocialiteOfWeChatException('Oauth user load failed, because platform is error.');
        }
        if (!isset($session[self::CHANNEL_KEY]) && $this->channel != $session[self::CHANNEL_KEY]) {
            throw new SocialiteOfWeChatException('Oauth user load failed, because channel is error.');
        }
        if (!$this->oauthUser && !$this->oauthUser = $session[self::OAUTH_USER_KEY]) {
            throw new SocialiteOfWeChatException('Oauth user load failed.');
        }

        return $this->oauthUser;
    }

    /**
     * Save oauth user info for unbound account to session.
     */
    public function saveOauthUser(): void
    {
        session([
            self::SESSION_NAME => [
                self::OAUTH_USER_KEY => $this->oauthUser,
                self::PLATFORM_KEY => $this->platform,
                self::CHANNEL_KEY => $this->channel,
            ],
        ]);
    }

    /**
     * Clear oauth user info for unbound account to session.
     */
    public function clearOauthUser(): void
    {
        session()->forget(self::SESSION_NAME);
    }

    /**
     * @return int
     */
    public function getSocialiteTypeOfUnion(): int
    {
        $socialiteType = config('extension.socialite.type');

        return $socialiteType::transform($this->platform, 'union');
    }

    /**
     * @return int
     */
    public function getSocialiteType(): int
    {
        $socialiteType = config('extension.socialite.type');

        return $socialiteType::transform($this->platform, $this->channel);
    }

    /**
     * Update wechat info to user info.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     */
    public function syncUserInfo($user): void
    {
        if (true === config('extension.socialite.channel.wechat.sync_nickname', true)) {
            if (!$user->nickname || preg_match('/(^'.config('extension.auth.nickname_prefix').')/', $user->nickname)) {
                $user->nickname = $this->getNickname();
            }
        }
        if (true === config('extension.socialite.channel.wechat.sync_avatar', true) && !$user->avatar) {
            $user->avatar = $this->getAvatar();
        }
        $user->save();
    }
}
