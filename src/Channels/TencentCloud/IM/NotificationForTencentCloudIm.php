<?php

namespace Papaedu\Extension\Channels\TencentCloud\IM;

use Illuminate\Notifications\Notification;

trait NotificationForTencentCloudIm
{
    public function routeNotificationForTencentCloudIm(?Notification $notification): string
    {
        return $this->uuid;
    }
}
