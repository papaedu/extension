<?php

namespace Papaedu\Extension\Channels\EasySms;

use Overtrue\EasySms\PhoneNumber;

trait NotificationForEasySms
{
    /**
     * @param  \Illuminate\Notifications\Notification|null  $notification
     * @return \Overtrue\EasySms\PhoneNumber
     */
    public function routeNotificationForEasySms($notification)
    {
        return new PhoneNumber($this->username ?? $this->mobile, '86');
    }
}