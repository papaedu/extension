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
    public static function validate(string $appName, string $ticket, string $userIp)
    {
        try {
            $cred = new Credential(
                config('extension.tencent_cloud.secret_id'),
                config('extension.tencent_cloud.secret_key')
            );
            $client = new CaptchaClient($cred, '');
            $req = new DescribeCaptchaMiniResultRequest();
            $req->setCaptchaType(9);
            $req->setTicket($ticket);
            $req->setUserIp($userIp);
            $req->setCaptchaAppId((int)config("extension.tencent_cloud.captcha.{$appName}.app_id"));
            $req->setAppSecretKey(config("extension.tencent_cloud.captcha.{$appName}.secret_key"));
            $resp = $client->DescribeCaptchaMiniResult($req);
            if (1 != $resp->getCaptchaCode()) {
                throw new HttpException(400, trans('extension::auth.geetest_failed'));
            }
        } catch (TencentCloudSDKException $e) {
            Log::error($e);
            throw new HttpException(400, trans('extension::auth.geetest_failed'));
        }
    }
}