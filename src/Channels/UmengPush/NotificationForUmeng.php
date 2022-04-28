<?php

namespace Papaedu\Extension\Channels\UmengPush;

trait NotificationForUmeng
{
    /**
     * @param  \Illuminate\Notifications\Notification|null  $notification
     * @return string
     */
    public function routeNotificationForUmengPush($notification)
    {
        return $this->username;
    }
}
