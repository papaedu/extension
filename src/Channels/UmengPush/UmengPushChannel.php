<?php

namespace Papaedu\Extension\Channels\UmengPush;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Notification;
use Papaedu\Extension\UmengPush\UmengPush;

class UmengPushChannel
{
    /**
     * @var \Papaedu\Extension\UmengPush\UmengPush
     */
    private $umengPush;

    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    private $events;

    public function __construct(UmengPush $umengPush, Dispatcher $events)
    {
        $this->umengPush = $umengPush;
        $this->events = $events;
    }

    /**
     * Send the notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$receiver = $notifiable->routeNotificationFor('umeng_push')) {
            return;
        }

        $message = $notification->toUmengPush($notifiable);

        $this->umengPush->send($receiver, $message);
    }
}
