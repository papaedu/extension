<?php

namespace Papaedu\Extension\Captcha\Client;

use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use TencentCloud\Captcha\V20190722\CaptchaClient;
use TencentCloud\Captcha\V20190722\Models\DescribeCaptchaMiniResultRequest;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Exception\TencentCloudSDKException;

class TencentClient
{
    public function validate(string $ticket, string $userIp, string $configName = ''): void
    {
        try {
            $cred = new Credential(
                config('tencent-cloud.secret_id'),
                config('tencent-cloud.secret_key')
            );
            $client = new CaptchaClient($cred, '');
            $req = new DescribeCaptchaMiniResultRequest();
            $req->setCaptchaType(9);
            $req->setTicket($ticket);
            $req->setUserIp($userIp);

            $captchaConfigName = $configName ? "tencent_cloud.captcha.{$configName}" : 'tencent_cloud.captcha';
            $req->setCaptchaAppId((int) config("{$captchaConfigName}.app_id"));
            $req->setAppSecretKey(config("{$captchaConfigName}.secret_key"));

            $resp = $client->DescribeCaptchaMiniResult($req);
            if (1 != $resp->getCaptchaCode()) {
                throw new HttpException(400, trans('extension::auth.geetest_failed'));
            }
        } catch (TencentCloudSDKException $e) {
            Log::error('', $e);
            throw new HttpException(400, trans('extension::auth.geetest_failed'));
        }
    }
}
