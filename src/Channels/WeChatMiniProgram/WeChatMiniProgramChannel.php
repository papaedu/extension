<?php

namespace Papaedu\Extension\Channels\WeChatMiniProgram;

use EasyWeChat;
use Illuminate\Notifications\Notification;
use Papaedu\Extension\Exceptions\InvalidArgumentException;

class WeChatMiniProgramChannel
{
    public function __construct(protected EasyWeChat $easyWeChat)
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
        if (! method_exists($notification, 'toWeChatMiniProgram')) {
            throw new InvalidArgumentException('The notifiable is invalid, not found method toWeChatMiniProgram.');
        }

        $receiver = $notifiable->routeNotificationFor('we_chat_mini_program', $notification);
        if (! is_string($receiver) || empty($receiver)) {
            throw new InvalidArgumentException('The to is invalid, is not string or empty.');
        }
        $message = $notification->toWeChatMiniProgram($receiver);

        $app = $this->easyWeChat->miniProgram($message->getChannel());
        $app->subscribe_message->send($message->toSendData());
    }
}
