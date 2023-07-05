<?php

namespace Papaedu\Extension\Channels\UmengPush;

use Illuminate\Notifications\Notification;

trait NotificationForUmeng
{
    public function routeNotificationForUmengPush(?Notification $notification): string
    {
        return $this->username;
    }
}
