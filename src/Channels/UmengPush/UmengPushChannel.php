<?php

namespace Papaedu\Extension\Channels\UmengPush;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\Exceptions\InvalidArgumentException;
use Papaedu\Extension\Http\Exceptions\UmengNotificationException;
use Papaedu\Extension\UmengPush\UmengPush;

class UmengPushChannel
{
    public function __construct(protected UmengPush $umengPush)
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
        if (! method_exists($notification, 'toUmengPush')) {
            throw new InvalidArgumentException('The notifiable is invalid, not found method toUmengPush.');
        }

        $receiver = $notifiable->routeNotificationFor('umeng_push', $notification);
        if (! is_string($receiver) || empty($receiver)) {
            throw new InvalidArgumentException('The to is invalid, is not string or empty.');
        }
        $message = $notification->toUmengPush($receiver);

        try {
            $this->umengPush->send($receiver, $message);
        } catch (UmengNotificationException $e) {
            Log::error('[umeng_push_channel]发送失败', [
                'error' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ],
                'to' => $receiver,
            ]);
        }
    }
}
