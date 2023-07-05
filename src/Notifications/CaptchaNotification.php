<?php

namespace Papaedu\Extension\Notifications;

use Illuminate\Notifications\Notification;
use Overtrue\EasySms\Contracts\PhoneNumberInterface;
use Papaedu\Extension\Channels\EasySms\EasySmsMessage;
use Papaedu\Extension\Channels\GetherCloudSms\GetherCloudSmsChannel;
use Papaedu\Extension\GetherCloud\GetherCloudSmsMessage;

class CaptchaNotification extends Notification
{
    public function __construct(protected string $captcha)
    {
    }

    public function via(object $notifiable): array
    {
        return [GetherCloudSmsChannel::class];
    }

    public function toEasySms(PhoneNumberInterface $notifiable): EasySmsMessage
    {
        $IDDCode = $notifiable->getIDDCode();

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

    public function toGetherCloudSms(PhoneNumberInterface $notifiable): GetherCloudSmsMessage
    {
        if ($notifiable->getIDDCode() == config('extension.locale.idd_code')) {
            $templateId = config('extension.auth.captcha.gether_template_id.domestic');
        } else {
            $templateId = config('extension.auth.captcha.gether_template_id.foreign');
        }

        return (new GetherCloudSmsMessage())
            ->setTemplateCode($templateId)
            ->setParams([
                'code' => $this->captcha,
            ]);
    }
}
