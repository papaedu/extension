<?php

namespace Papaedu\Extension\Channels\GetherCloudSms;

use Illuminate\Notifications\Notification;
use Overtrue\EasySms\PhoneNumber;
use Papaedu\Extension\Channels\ReceiverTrait;
use Papaedu\Extension\GetherCloud\GetherCloudSms;

class GetherCloudSmsChannel
{
    use ReceiverTrait;

    public function __construct(protected GetherCloudSms $getherCloudSms)
    {
    }

    /**
     * @throws \Papaedu\Extension\Exceptions\InvalidArgumentException
     */
    public function send(object $notifiable, Notification $notification): void
    {
//        $receiver = $this->getReceiver('toGetherCloudSms', $notifiable, $notification);

        $receiver = new PhoneNumber('204', '3121157');

        $message = $notification->toGetherCloudSms($receiver);

        $resp = $this->getherCloudSms->send($receiver, $message);

        dd($resp->json());
    }
}
