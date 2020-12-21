<?php

namespace Papaedu\Extension\Socialite;

use Papaedu\Extension\Enums\SocialiteType;

trait SocialiteTrait
{
    /**
     * @param  string  $type
     * @param  int  $userId
     * @param  string  $openid
     * @param  string  $nickname
     */
    protected function bindSocialite(string $type, int $userId, string $openid, string $nickname = '')
    {
        $this->socialiteModel()->updateOrCreate([
            'type' => $type,
            'openid' => $openid,
        ], [
            $this->userId() => $userId,
            'nickname' => $nickname,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function socialiteModel()
    {
        $model = config('extension.socialite.model');

        return new $model;
    }

    /**
     * @return int
     */
    protected function socialiteTypeUnionId(): int
    {
        return SocialiteType::WECHAT_UNION_ID;
    }

    /**
     * @return string
     */
    protected function userId(): string
    {
        return 'user_id';
    }
}
