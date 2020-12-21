<?php

namespace Papaedu\Extension\Channels\WeChatMiniProgram;

trait NotificationForWeChatMiniProgram
{
    /**
     * @param  \Illuminate\Notifications\Notification|null  $notification
     * @return string
     */
    public function routeNotificationForWechatMiniProgram($notification)
    {
        return $this->socialites()->where('type', $notification->type)->first('openid')->openid ?? null;
    }
}
