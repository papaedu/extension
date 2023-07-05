<?php

namespace Papaedu\Extension\Channels\GetherCloudSms;

use Illuminate\Notifications\Notification;
use Overtrue\EasySms\Contracts\PhoneNumberInterface;
use Papaedu\Extension\Exceptions\InvalidArgumentException;
use Papaedu\Extension\GetherCloud\GetherCloudSms;

class GetherCloudSmsChannel
{
    public function __construct(protected GetherCloudSms $getherCloudSms)
    {
    }

    /**
     * @throws \Papaedu\Extension\Exceptions\InvalidArgumentException
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if (! method_exists($notifiable, 'routeNotificationFor')) {
            throw new InvalidArgumentException('The notifiable is invalid, not found method routeNotificationFor.');
        }
        if (! method_exists($notification, 'toGetherCloudSms')) {
            throw new InvalidArgumentException('The notifiable is invalid, not found method toEasySms.');
        }

        $receiver = $notifiable->routeNotificationFor('sms', $notification);
        if (! $receiver instanceof PhoneNumberInterface) {
            throw new InvalidArgumentException('The to is invalid, not instanceof PhoneNumberInterface');
        }

        $message = $notification->toGetherCloudSms($receiver);

      $resp =   $this->getherCloudSms->send($receiver, $message);


      dd($resp->json());
    }
}
