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
     */
    public function send($notifiable, Notification $notification)
    {
        if ($notifiable instanceof Model) {
            $to = $notifiable->routeNotificationFor('we_chat_mini_program', $notification);
            if (!isset($to->openid)) {
                return;
            }
        } else {
            return;
        }

        $message = $notification->toWeChatMiniProgram($to);

        $app = $this->easyWeChat->miniProgram($message->getChannel());
        $app->subscribe_message->send($message->toSendData());
    }
}
