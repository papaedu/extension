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
     * @param  int  $iddCode
     * @param  string  $phoneNumber
     * @param  string  $captcha
     */
    public static function login(int $iddCode, string $phoneNumber, string $captcha)
    {
        self::send($iddCode, $phoneNumber, $captcha);
    }

    /**
     * @param  int  $iddCode
     * @param  string  $phoneNumber
     * @param  string  $captcha
     */
    public static function register(int $iddCode, string $phoneNumber, string $captcha)
    {
        self::send($iddCode, $phoneNumber, $captcha);
    }

    /**
     * @param  int  $iddCode
     * @param  string  $phoneNumber
     * @param  string  $captcha
     */
    public static function forgot(int $iddCode, string $phoneNumber, string $captcha)
    {
        self::send($iddCode, $phoneNumber, $captcha);
    }

    /**
     * @param  int  $iddCode
     * @param  string  $phoneNumber
     * @param  string  $captcha
     */
    public static function reset(int $iddCode, string $phoneNumber, string $captcha)
    {
        self::send($iddCode, $phoneNumber, $captcha);
    }

    /**
     * @param  int  $iddCode
     * @param  string  $phoneNumber
     * @param  string  $captcha
     */
    protected static function send(int $iddCode, string $phoneNumber, string $captcha)
    {
        try {
            Notification::route(EasySmsChannel::class, $phoneNumber)->notify(new Captcha($captcha));
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 'isv.BUSINESS_LIMIT_CONTROL':// 业务限流
                    Log::error('[SMS] Captcha limit control.', [
                        'phone_number' => $phoneNumber,
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
