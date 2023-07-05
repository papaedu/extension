<?php

namespace Papaedu\Extension\Channels\WeChatMiniProgram;

use Illuminate\Notifications\Notification;

trait NotificationForWeChatMiniProgram
{
    /**
     * @param  \Illuminate\Notifications\Notification|null  $notification
     * @return string
     */
    public function routeNotificationForWeChatMiniProgram(?Notification $notification): string
    {
        return $this->socialites()->first()->open_id ?? '';
    }
}
