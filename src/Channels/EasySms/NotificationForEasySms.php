<?php

namespace Papaedu\Extension\Channels\EasySms;

use Illuminate\Notifications\Notification;
use Overtrue\EasySms\PhoneNumber;

trait NotificationForEasySms
{
    public function routeNotificationForEasySms(?Notification $notification): PhoneNumber
    {
        return new PhoneNumber($this->username, $this->idd_code ?? config('extension.locale.idd_code'));
    }
}
