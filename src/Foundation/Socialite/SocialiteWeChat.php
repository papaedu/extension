<?php

namespace Papaedu\Extension\Foundation\Socialite;

use Illuminate\Validation\ValidationException;
use Overtrue\Socialite\User;
use Papaedu\Extension\Support\Extend;

trait SocialiteWeChat
{
    /**
     * 绑定微信
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function bindWechat()
    {
        /** @var \Overtrue\Socialite\User $user */
        $user = session('wechat.oauth_user');
        $channel = session('wechat.channel');

        if (!$user || !$channel) {
            throw ValidationException::withMessages([
                'socialite' => [trans('extension::socialite.bind_failed')],
            ]);
        }
        if ($this->validateWechatUnionId($user->getRaw()['unionid'] ?? '')) {
            throw ValidationException::withMessages([
                'socialite' => [trans('extension::socialite.wechat_already_bind')],
            ]);
        }
        if ($this->validateUserId()) {
            throw ValidationException::withMessages([
                'socialite' => [trans('extension::socialite.mobile_already_bind')],
            ]);
        }

        // 绑定unionID
        $this->bindSocialite('union', $this->guard()->id(), $user->getRaw()['unionid'] ?? '', $user->getNickname());
        // 绑定渠道openid
        $this->bindSocialite($channel, $this->guard()->id(), $user->getId());

        // 检测是否需要更新头像等信息
        $this->checkUserInfo($user);
    }

    /**
     * @param  \Overtrue\Socialite\User  $oauthUser
     */
    private function checkUserInfo(User $oauthUser)
    {
        $nickname = $this->guard()->user();
        $nicknamePrefix = config('extension.auth.nickname_prefix');
        if (!$nickname || preg_match('/(^'.$nicknamePrefix.')/', $nickname) || Extend::isMobile($nickname)) {
            $this->guard()->user()->nickname = $oauthUser->getNickname();
        }
        if (!$this->guard()->user()->avatar) {
            $this->guard()->user()->avatar = $oauthUser->getAvatar();
        }
        $this->guard()->user()->save();
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

        return Socialite::where('openid', $unionId)
            ->where('type', SocialiteType::WeChatUnionId)
            ->exists();
    }

    /**
     * 验收用户是否已经绑定过微信
     *
     * @return bool
     */
    protected function validateUserId()
    {
        return Socialite::where('guest_id', $this->guard()->id())
            ->where('type', SocialiteType::WeChatUnionId)
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
        $type = SocialiteType::transform($channel);
        if (!$type) {
            return;
        }

        Socialite::updateOrCreate([
            'type' => $type,
            'openid' => $openId,
        ], [
            'guest_id' => $guestId,
            'nickname' => $nickname,
        ]);
    }
}
