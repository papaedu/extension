<?php

namespace Papaedu\Extension\Socialite;

use Illuminate\Validation\ValidationException;

/**
 * Trait BindingWeChat
 *
 * @package Papaedu\Extension\Socialite
 * @deprecated
 * 暂时未使用,也未完成,上面的弃用只是做个标记,不要误用了
 */
trait BindingWeChat
{
    use SocialiteTrait;

    /**
     * Binding wechat.
     *
     * @param $user
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Papaedu\Extension\Http\Exceptions\SocialiteOfWeChatException
     * @throws \Papaedu\Extension\Http\Exceptions\WeChatUndefinedUnionIdException
     */
    public function bindWeChat($user)
    {
        $application = SocialiteApplication::wechat();
        $application->loadOauthUserBySession();

        if ($this->validateWechatUnionId($application->getId())) {
            throw ValidationException::withMessages([
                'socialite' => [trans('extension::socialite.wechat.already_bind')],
            ]);
        }
        if ($this->validateUserId($user)) {
            throw ValidationException::withMessages([
                'socialite' => [trans('extension::socialite.wechat.already_be_bind')],
            ]);
        }

        // 绑定unionID
        if (config('extension.socialite.channel.wechat.enable_union_id')) {
            $this->bindSocialite(
                $application->getSocialiteTypeOfUnion(),
                $user->id,
                $application->getUnionId(),
                $application->getNickname()
            );
        }
        // 绑定渠道openid
        $this->bindSocialite(
            $application->getSocialiteType(),
            $user->id,
            $application->getOpenid(),
            $application->getNickname()
        );

        // 更新用户信息
        $application->syncUserInfo($user);

        $application->clearOauthUser();
    }

    /**
     * 验证微信号是否已绑定其他手机号
     *
     * @param  string  $weChatId
     * @return bool
     */
    protected function validateWechatUnionId(string $weChatId)
    {
        return $this->socialiteModel()
            ->where('openid', $weChatId)
            ->where('type', $this->socialiteTypeUnionId())
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
        return $this->socialiteModel()
            ->where('guest_id', $user->id)
            ->where('type', $this->socialiteTypeUnionId())
            ->exists();
    }
}
