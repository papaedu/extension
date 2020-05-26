<?php

namespace Papaedu\Extension\Channels\EasySms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Overtrue\EasySms\EasySms;

class EasySmsChannel
{
    protected $client;

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
     * @param $notifiable
     * @param  Notification  $notification
     */
    public function send($notifiable, Notification $notification)
    {
        if ($notifiable instanceof Model) {
            $to = $notifiable->routeNotificationFor('easysms', $notification);
        } elseif ($notifiable instanceof AnonymousNotifiable) {
            $to = $notifiable->routes[__CLASS__];
        }

        $message = $notification->toEasySms($notifiable);

        $this->easySms->send($to, $message);
    }
}
