<?php

namespace Papaedu\Extension\Socialite;

interface WeChatInterface
{
    /**
     * Attempt to oauth the wechat by code.
     *
     * @param  string  $code
     */
    public function attemptOauth(string $code): void;

    /**
     * Get oauth user.
     *
     * @return \Overtrue\Socialite\User|array
     */
    public function loadOauthUserBySession();

    /**
     * Get oauth user union id when union id in information, else return oauth user openid.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Get oauth user openid.
     *
     * @return string
     */
    public function getOpenid(): string;

    /**
     * Get oauth user union id.
     *
     * @return string
     */
    public function getUnionId(): string;

    /**
     * Get oauth user nickname.
     *
     * @return string
     */
    public function getNickname(): string;

    /**
     * Get oauth user avatar.
     *
     * @return string
     */
    public function getAvatar(): string;

    /**
     * Update user information with oauth user information.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     */
    public function syncUserInfo($user): void;

    /**
     * Save oauth user information for unbound account to session.
     */
    public function saveOauthUser(): void;

    public function decryptData(string $sessionKey, string $iv, string $encryptedData): array;
}
