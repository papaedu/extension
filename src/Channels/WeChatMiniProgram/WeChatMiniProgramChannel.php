<?php

namespace Papaedu\Extension\Channels\WeChatMiniProgram;

use EasyWeChat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;

class WeChatMiniProgramChannel
{
    /**
     * @var EasyWeChat
     */
    private EasyWeChat $easyWeChat;

    public function __construct(EasyWeChat $easyWeChat)
    {
        $this->easyWeChat = $easyWeChat;
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
            $to = $notifiable->routeNotificationFor('we_chat_mini_program', $notification);
        } elseif ($notifiable instanceof AnonymousNotifiable) {
            $to = $notifiable->routes[__CLASS__];
        } else {
            return;
        }

        $message = $notification->toWeChatMiniProgram($to);

        $response = $this->easyWeChat->miniProgram($message->getChannel())->uniform_message->send($message->toSendData());

        dd($response);
    }
}
