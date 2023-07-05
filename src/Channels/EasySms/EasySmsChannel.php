<?php

namespace Papaedu\Extension\Channels\EasySms;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Overtrue\EasySms\Contracts\PhoneNumberInterface;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use Papaedu\Extension\Exceptions\InvalidArgumentException;

class EasySmsChannel
{
    public function __construct(protected EasySms $easySms)
    {
    }

    /**
     * @throws \Papaedu\Extension\Exceptions\InvalidArgumentException
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if (! method_exists($notifiable, 'routeNotificationFor')) {
            throw new InvalidArgumentException('The notifiable is invalid, not found method routeNotificationFor.');
        }
        if (! method_exists($notification, 'toEasySms')) {
            throw new InvalidArgumentException('The notifiable is invalid, not found method toEasySms.');
        }

        $receiver = $notifiable->routeNotificationFor('sms', $notification);
        if (!$receiver instanceof PhoneNumberInterface) {
            throw new InvalidArgumentException('The to is invalid, not instanceof PhoneNumberInterface');
        }
        $message = $notification->toEasySms($receiver);

        try {
            $this->easySms->send($receiver, $message);
        } catch (NoGatewayAvailableException $e) {
            Log::error('[easy_sms_channel]发送失败：未找到匹配网关', [
                'error' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ],
                'to' => [
                    'idd_code' => $receiver->getIDDCode(),
                    'number' => $receiver->getNumber(),
                ],
            ]);
        }
    }
}
