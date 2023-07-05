<?php

namespace Papaedu\Extension\Captcha;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Overtrue\EasySms\Exceptions\GatewayErrorException;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use Overtrue\EasySms\PhoneNumber;
use Papaedu\Extension\Channels\GetherCloudSms\GetherCloudSmsChannel;
use Papaedu\Extension\Notifications\CaptchaNotification;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CaptchaSender
{
    public static function send(string $phoneNumber, string $IDDCode, string $captcha): void
    {
        Notification::route(GetherCloudSmsChannel::class, new PhoneNumber($phoneNumber, $IDDCode))
            ->notify(new CaptchaNotification($captcha));

        try {
            Notification::route(GetherCloudSmsChannel::class, new PhoneNumber($phoneNumber, $IDDCode))
                ->notify(new CaptchaNotification($captcha));
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
                'exceptions' => $e->getExceptions(),
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

    protected static function exceptionAliYun(array $raw): string
    {
        return match ($raw['result']) {
            'isv.MOBILE_NUMBER_ILLEGAL' => trans('extension::validator.mobile_number_illegal'),
            'isv.DAY_LIMIT_CONTROL', 'isv.MOBILE_COUNT_OVER_LIMIT', 'isv.BUSINESS_LIMIT_CONTROL' => trans('extension::validator.sms.business_limit_control'),
            default => trans('extension::validator.sms.others_error'),
        };
    }

    protected static function exceptionTencentCloud(array $raw): string
    {
        return match ($raw['result']) {
            1016 => trans('extension::validator.mobile_number_illegal'),
            1022, 1023, 1024, 1025, 1026 => trans('extension::validator.sms.business_limit_control'),
            default => trans('extension::validator.sms.others_error'),
        };
    }
}
