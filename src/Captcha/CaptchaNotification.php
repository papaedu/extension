<?php

namespace Papaedu\Extension\Captcha;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Overtrue\EasySms\Exceptions\GatewayErrorException;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use Overtrue\EasySms\PhoneNumber;
use Papaedu\Extension\Channels\EasySms\EasySmsChannel;
use Papaedu\Extension\Notifications\Captcha;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CaptchaNotification
{
    /**
     * @param  int  $IDDCode
     * @param  string  $phoneNumber
     * @param  string  $captcha
     */
    public static function login(int $IDDCode, string $phoneNumber, string $captcha)
    {
        self::send($IDDCode, $phoneNumber, $captcha);
    }

    /**
     * @param  int  $IDDCode
     * @param  string  $phoneNumber
     * @param  string  $captcha
     */
    public static function register(int $IDDCode, string $phoneNumber, string $captcha)
    {
        self::send($IDDCode, $phoneNumber, $captcha);
    }

    /**
     * @param  int  $IDDCode
     * @param  string  $phoneNumber
     * @param  string  $captcha
     */
    public static function forgot(int $IDDCode, string $phoneNumber, string $captcha)
    {
        self::send($IDDCode, $phoneNumber, $captcha);
    }

    /**
     * @param  int  $IDDCode
     * @param  string  $phoneNumber
     * @param  string  $captcha
     */
    public static function reset(int $IDDCode, string $phoneNumber, string $captcha)
    {
        self::send($IDDCode, $phoneNumber, $captcha);
    }

    /**
     * @param  int  $IDDCode
     * @param  string  $phoneNumber
     * @param  string  $captcha
     */
    protected static function send(int $IDDCode, string $phoneNumber, string $captcha)
    {
        try {
            Notification::route(EasySmsChannel::class, new PhoneNumber($phoneNumber, $IDDCode))->notify(new Captcha($captcha));
        } catch (GatewayErrorException $e) {
            foreach ($e->getExceptions() as $gateway => $exception) {
                if ('aliyun' == $gateway) {
                    $message = static::exceptionAliyun($exception->raw);
                } elseif ('qcloud' == $gateway) {
                    $message = static::exceptionQcloud($exception->raw);
                } else {
                    $message = '发送失败，请稍候再试';
                }
            }

            Log::error('[SMS] GatewayErrorException, Captcha send error.', [
                'idd_code' => $IDDCode,
                'phone_number' => $phoneNumber,
                'exceptions' => $e->getExceptions(),
            ]);

            throw new BadRequestHttpException($message);
        } catch (NoGatewayAvailableException $e) {
            Log::error('[SMS] NoGatewayAvailableException, Captcha send error.', [
                'idd_code' => $IDDCode,
                'phone_number' => $phoneNumber,
                'exceptions' => $e->getExceptions(),
            ]);

            throw new BadRequestHttpException('发送失败，请稍候再试');
        } catch (Exception $e) {
            Log::error('[SMS] Captcha send error.', [
                'idd_code' => $IDDCode,
                'phone_number' => $phoneNumber,
                'exceptions' => $e->getTrace(),
            ]);

            throw new BadRequestHttpException('发送失败，请稍候再试');
        }
    }

    protected static function exceptionAliyun(array $raw)
    {
        switch ($raw['result']) {
            case 'isv.MOBILE_NUMBER_ILLEGAL':
                return '手机号格式错误';
                break;
            case 'isv.DAY_LIMIT_CONTROL':
            case 'isv.MOBILE_COUNT_OVER_LIMIT':
            case 'isv.BUSINESS_LIMIT_CONTROL':
                return '发送频繁，请稍候再试';
                break;
            default:
                return '发送失败，请稍候再试';
        }
    }

    protected static function exceptionQcloud(array $raw)
    {
        switch ($raw['result']) {
            case 1016:
                return '手机号格式错误';
                break;
            case 1022:
            case 1023:
            case 1024:
            case 1025:
            case 1026:
                return '发送频繁，请稍候再试';
                break;
            default:
                return '发送失败，请稍候再试';
        }
    }
}
