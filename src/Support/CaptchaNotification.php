<?php

namespace Papaedu\Extension\Support;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Papaedu\Extension\Channels\EasySms\EasySmsChannel;
use Papaedu\Extension\Notifications\Captcha;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CaptchaNotification
{
    /**
     * @param  string  $mobile
     * @param  string  $captcha
     */
    public static function login(string $mobile, string $captcha)
    {
        self::send($mobile, $captcha);
    }

    /**
     * @param  string  $mobile
     * @param  string  $captcha
     */
    public static function register(string $mobile, string $captcha)
    {
        self::send($mobile, $captcha);
    }

    /**
     * @param  string  $mobile
     * @param  string  $captcha
     */
    public static function forgot(string $mobile, string $captcha)
    {
        self::send($mobile, $captcha);
    }

    /**
     * @param  string  $mobile
     * @param  string  $captcha
     */
    public static function reset(string $mobile, string $captcha)
    {
        self::send($mobile, $captcha);
    }

    /**
     * @param  string  $mobile
     * @param  string  $captcha
     */
    protected static function send(string $mobile, string $captcha)
    {
        try {
            Notification::route(EasySmsChannel::class, $mobile)->notify(new Captcha($captcha));
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 'isv.BUSINESS_LIMIT_CONTROL':// 业务限流
                    Log::error('[SMS] Captcha limit control.', [
                        'mobile' => $mobile,
                    ]);
                    $errorMessage = '发送频繁，请稍候再试';
                    break;
                default:
                    Log::error('[SMS] Captcha send error.', $e->getTrace());
                    $errorMessage = '发送失败，请稍候再试';
            }
            throw new BadRequestHttpException($errorMessage);
        }
    }
}
