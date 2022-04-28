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
     * @param  int  $phoneNumber
     * @param  string  $IDDCode
     * @param  string  $captcha
     */
    public static function send(int $phoneNumber, string $IDDCode, string $captcha)
    {
        try {
            Notification::route(
                EasySmsChannel::class,
                new PhoneNumber($phoneNumber, $IDDCode)
            )->notify(new Captcha($captcha));
        } catch (GatewayErrorException $e) {
            $message = trans('extension::validator.sms.others_error');
            foreach ($e->getExceptions() as $gateway => $exception) {
                if ('aliyun' == $gateway) {
                    $message = static::exceptionAliYun($exception->raw);
                } elseif ('qcloud' == $gateway) {
                    $message = static::exceptionTencentCloud($exception->raw);
                }
            }

            Log::error('[SMS] GatewayErrorException, Captcha send error.', [
                'idd_code' => $IDDCode,
                'phone_number' => $phoneNumber,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);

            throw new BadRequestHttpException($message);
        } catch (NoGatewayAvailableException $e) {
            Log::error('[SMS] NoGatewayAvailableException, Captcha send error.', [
                'idd_code' => $IDDCode,
                'phone_number' => $phoneNumber,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);

            throw new BadRequestHttpException(trans('extension::validator.sms.others_error'));
        } catch (Exception $e) {
            Log::error('[SMS] Captcha send error.', [
                'idd_code' => $IDDCode,
                'phone_number' => $phoneNumber,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);

            throw new BadRequestHttpException(trans('extension::validator.sms.others_error'));
        }
    }

    /**
     * @param  array  $raw
     * @return string
     */
    protected static function exceptionAliYun(array $raw): string
    {
        switch ($raw['result']) {
            case 'isv.MOBILE_NUMBER_ILLEGAL':
                $message = trans('extension::validator.mobile_number_illegal');
                break;
            case 'isv.DAY_LIMIT_CONTROL':
            case 'isv.MOBILE_COUNT_OVER_LIMIT':
            case 'isv.BUSINESS_LIMIT_CONTROL':
                $message = trans('extension::validator.sms.business_limit_control');
                break;
            default:
                $message = trans('extension::validator.sms.others_error');
        }

        return $message;
    }

    /**
     * @param  array  $raw
     * @return string
     */
    protected static function exceptionTencentCloud(array $raw): string
    {
        switch ($raw['result']) {
            case 1016:
                $message = trans('extension::validator.mobile_number_illegal');
                break;
            case 1022:
            case 1023:
            case 1024:
            case 1025:
            case 1026:
                $message = trans('extension::validator.sms.business_limit_control');
                break;
            default:
                $message = trans('extension::validator.sms.others_error');
        }

        return $message;
    }
}
