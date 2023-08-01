<?php

namespace Papaedu\Extension\GetherCloud;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Overtrue\EasySms\Contracts\PhoneNumberInterface;

class GetherCloudSms
{
    protected const DOMESTIC_ENDPOINT_URL = 'https://cloud.gether.net/smartmarket/msgService/sendMessage';

    protected const INTERNATIONAL_ENDPOINT_URL = 'https://cloud.gether.net/smartmarket/internationalMsg/sendMsgToMultiple';

    public function __construct(protected array $config)
    {
    }

    public function send(PhoneNumberInterface $receiver, GetherCloudSmsMessage $message): Response
    {
        if ($receiver->getIDDCode() == config('extension.locale.idd_code')) {
            return $this->sendByDomestic($receiver, $message);
        } else {
            return $this->sendByInternational($receiver, $message);
        }
    }

    public function sendByDomestic(PhoneNumberInterface $receiver, GetherCloudSmsMessage $message): Response
    {
        return Http::acceptJson()
            ->asJson()
            ->post(self::DOMESTIC_ENDPOINT_URL, [
                'accessKey' => $this->config['access_key'],
                'accessSecret' => $this->config['access_secret'],
                'signCode' => $this->config['sign_code'],
                'templateCode' => $message->getTemplateCode(),
                'classificationSecret' => $this->config['classification_secret'],
                'phone' => $receiver->getNumber(),
                'params' => $message->getParams(),
            ]);
    }

    public function sendByInternational(PhoneNumberInterface $receiver, GetherCloudSmsMessage $message): Response
    {
        return Http::acceptJson()
            ->asJson()
            ->post(self::INTERNATIONAL_ENDPOINT_URL, [
                'accessKey' => $this->config['access_key'],
                'accessSecret' => $this->config['access_secret'],
                'signCode' => $this->config['sign_code'],
                'templateCode' => $message->getTemplateCode(),
                'classificationSecret' => $this->config['classification_secret'],
                'phone' => $receiver->getUniversalNumber(),
                'params' => $message->getParams(),
            ]);
    }
}
