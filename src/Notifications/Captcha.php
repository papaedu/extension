<?php

namespace Papaedu\Extension\Notifications;

use Illuminate\Notifications\Notification;
use Overtrue\EasySms\Contracts\PhoneNumberInterface;
use Papaedu\Extension\Channels\EasySms\EasySmsChannel;
use Papaedu\Extension\Channels\EasySms\EasySmsMessage;

class Captcha extends Notification
{
    /**
     * @var string
     */
    private string $captcha;

    public function __construct(string $captcha)
    {
        $this->captcha = $captcha;
    }

    /**
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return [EasySmsChannel::class];
    }

    /**
     * @param  mixed  $notifiable
     * @return \Papaedu\Extension\Channels\EasySms\EasySmsMessage|void
     */
    public function toEasySms($notifiable)
    {
        if ($notifiable instanceof PhoneNumberInterface) {
            $IDDCode = $notifiable->getIDDCode();
        } else {
            return;
        }

        if ($IDDCode == config('extension.locale.idd_code')) {
            $templateId = config('extension.auth.captcha.sms_template_id.domestic.aliyun');
            $gateways = ['aliyun'];
        } else {
            $templateId = config('extension.auth.captcha.sms_template_id.foreign.qcloud');
            $gateways = ['qcloud'];
        }

        return (new EasySmsMessage())
            ->setTemplate($templateId)
            ->setData([
                'code' => $this->captcha,
            ])
            ->setGateways($gateways);
    }
}
