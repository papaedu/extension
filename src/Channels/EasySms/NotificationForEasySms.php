<?php

namespace Papaedu\Extension\Channels\EasySms;

use Overtrue\EasySms\PhoneNumber;
use Propaganistas\LaravelPhone\PhoneNumber as PhoneNumberFormatter;

trait NotificationForEasySms
{
    /**
     * @param  \Illuminate\Notifications\Notification|null  $notification
     * @return \Overtrue\EasySms\PhoneNumber
     */
    public function routeNotificationForEasySms($notification)
    {
        $formatter = PhoneNumberFormatter::make(
            $this->username,
            $this->idd_code ?? config('extension.locale.iso_code')
        );

        return new PhoneNumber(
            $this->username,
            $formatter->getPhoneNumberInstance()->getCountryCode()
        );
    }
}
