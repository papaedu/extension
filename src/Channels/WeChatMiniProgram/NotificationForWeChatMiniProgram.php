<?php

namespace Papaedu\Extension\Channels\WeChatMiniProgram;

trait NotificationForWeChatMiniProgram
{
    /**
     * @param  \Illuminate\Notifications\Notification|null  $notification
     * @return string
     */
    public function routeNotificationForWeChatMiniProgram($notification)
    {
        return $this->socialites()->first() ?? null;
    }
}
