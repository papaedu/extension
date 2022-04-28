<?php

namespace Papaedu\Extension\Channels\TencentCloud\IM;

trait NotificationForTencentCloudIm
{
    /**
     * @param  \Illuminate\Notifications\Notification|null  $notification
     * @return string
     */
    public function routeNotificationForTencentCloudIm($notification)
    {
        return $this->uuid;
    }
}
