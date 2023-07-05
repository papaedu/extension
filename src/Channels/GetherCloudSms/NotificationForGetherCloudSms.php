<?php

namespace Papaedu\Extension\Channels\GetherCloudSms;

use Illuminate\Notifications\Notification;
use Propaganistas\LaravelPhone\PhoneNumber;
use Propaganistas\LaravelPhone\PhoneNumber as PhoneNumberFormatter;

trait NotificationForGetherCloudSms
{
    public function routeNotificationForGether(?Notification $notification): PhoneNumber
    {
        $formatter = PhoneNumberFormatter::make(
            $this->username,
            $this->idd_code ?? config('extension.locale.iso_code')
        );

        return PhoneNumber::make(
            $this->username,
            $this->idd_code ?? config('extension.locale.iso_code')
        );
    }
}
