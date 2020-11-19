<?php

namespace Papaedu\Extension\Foundation\Socialite;

use Illuminate\Validation\ValidationException;
use Overtrue\Socialite\User;

trait SocialiteWeChat
{
    /**
     * @var bool
     */
    protected $syncWeChatNickname = true;

    /**
     * @var bool
     */
    protected $syncWeChatAvatar = true;

    /**
     * 绑定微信
     *
     * @param  \Overtrue\Socialite\User  $oauthUser
     * @param  string  $channel
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     */
    protected function bindWechat(User $oauthUser, string $channel, $user)
    {
        if (!$oauthUser || !$channel) {
            throw ValidationException::withMessages([
                'socialite' => [trans('extension::socialite.bind_failed')],
            ]);
        }
        if ($this->validateWechatUnionId($oauthUser->getRaw()['unionid'] ?? '')) {
            throw ValidationException::withMessages([
                'socialite' => [trans('extension::socialite.wechat_already_bind')],
            ]);
        }
        if ($this->validateUserId($user)) {
            throw ValidationException::withMessages([
                'socialite' => [trans('extension::socialite.mobile_already_bind')],
            ]);
        }

        // 绑定unionID
        $this->bindSocialite('union', $user->id, $oauthUser->getRaw()['unionid'] ?? '', $oauthUser->getNickname());
        // 绑定渠道openid
        $this->bindSocialite($channel, $user->id, $oauthUser->getId());

        // 更新用户信息
        $this->syncWeChatUserInfo($oauthUser, $user);
    }

    /**
     * @param  \Overtrue\Socialite\User  $oauthUser
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     */
    private function syncWeChatUserInfo(User $oauthUser, $user)
    {
        if (true === $this->syncWeChatNickname) {
            if (!$user->nickname || preg_match('/(^'.config('extension.auth.nickname_prefix').')/', $user->nickname)) {
                $user->nickname = $oauthUser->getNickname();
            }
        }
        if (true === $this->syncWeChatAvatar && !$user->avatar) {
            $user->avatar = $oauthUser->getAvatar();
        }
        $user->save();
    }

    /**
     * 验证微信号是否已绑定其他手机号
     *
     * @param  string  $unionId
     * @return bool
     */
    protected function validateWechatUnionId(string $unionId)
    {
        if (!$unionId) {
            return false;
        }

        return $this->getSocialiteModel()->where('openid', $unionId)
            ->where('type', $this->getSocialiteType()::WeChatUnionId)
            ->exists();
    }

    /**
     * 验收用户是否已经绑定过微信
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return bool
     */
    protected function validateUserId($user)
    {
        return $this->getSocialiteModel()->where('guest_id', $user->id)
            ->where('type', $this->getSocialiteType()::WeChatUnionId)
            ->exists();
    }

    /**
     * @param  string  $channel
     * @param  int  $guestId
     * @param  string  $openId
     * @param  string  $nickname
     */
    protected function bindSocialite(string $channel, int $guestId, string $openId, string $nickname = '')
    {
        if (!$openId) {
            return;
        }
        $type = $this->getSocialiteType()::transform($channel);
        if (!$type) {
            return;
        }

        $this->getSocialiteModel()->updateOrCreate([
            'type' => $type,
            'openid' => $openId,
        ], [
            'guest_id' => $guestId,
            'nickname' => $nickname,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function getSocialiteModel()
    {
        $model = config('extension.socialite.model');

        return new $model;
    }

    /**
     * @return object
     */
    protected function getSocialiteType()
    {
        return config('extension.socialite.type');
    }
}
