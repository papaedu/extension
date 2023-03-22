<?php

namespace Papaedu\Extension\Channels\EasySms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Overtrue\EasySms\Contracts\PhoneNumberInterface;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

class EasySmsChannel
{
    /**
     * @var \Overtrue\EasySms\EasySms
     */
    private $easySms;

    public function __construct(EasySms $easySms)
    {
        $this->easySms = $easySms;
    }

    /**
     * Send the notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if ($notifiable instanceof Model) {
            $to = $notifiable->routeNotificationFor('easy_sms', $notification);
        } elseif ($notifiable instanceof AnonymousNotifiable) {
            $to = $notifiable->routes[__CLASS__];
        } else {
            return;
        }
        $message = $notification->toEasySms($to);
        if (is_null($message)) {
            Log::warning(class_basename($notification).' not found method toEasySms.');

            return;
        }

        try {
            $this->easySms->send($to, $message);
        } catch (NoGatewayAvailableException $e) {
            if ($to instanceof PhoneNumberInterface) {
                $toMessage = [
                    'idd_code' => $to->getIDDCode(),
                    'number' => $to->getNumber(),
                ];
            } else {
                $toMessage = $to;
            }

            Log::error('短信发送失败：未找到匹配网关', [
                'error' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ],
                'to' => $toMessage,
            ]);
        }
    }
}
