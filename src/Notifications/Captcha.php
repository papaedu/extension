<?php

namespace Papaedu\Extension\Notifications;

use Illuminate\Notifications\Notification;
use Papaedu\Extension\Channels\EasySms\EasySmsChannel;
use Papaedu\Extension\Channels\EasySms\EasySmsMessage;

class Captcha extends Notification
{
    /**
     * @var string
     */
    private $captcha;

    public function __construct(string $captcha)
    {
        $this->captcha = $captcha;
    }

    public function via($notifiable)
    {
        return [EasySmsChannel::class];
    }

    public function toEasySms($notifiable)
    {
        return (new EasySmsMessage)
            ->setTemplate(config('extension.captcha.sms_template_id'))
            ->setData([
                'code' => $this->captcha,
            ]);
    }
}
