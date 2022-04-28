<?php

namespace Papaedu\Extension\Channels\EasySms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Overtrue\EasySms\EasySms;

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

        $this->easySms->send($to, $message);
    }
}
