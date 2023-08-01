<?php

namespace Papaedu\Extension\Channels\EasySms;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use Papaedu\Extension\Channels\ReceiverTrait;

class EasySmsChannel
{
    use ReceiverTrait;

    public function __construct(protected EasySms $easySms)
    {
    }

    /**
     * @throws \Papaedu\Extension\Exceptions\InvalidArgumentException
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     */
    public function send(object $notifiable, Notification $notification): void
    {
        $receiver = $this->getReceiver('toEasySms', $notifiable, $notification);
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
