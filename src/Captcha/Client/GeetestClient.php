<?php

namespace Papaedu\Extension\Captcha\Client;

use Papaedu\Extension\Facades\Geetest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GeetestClient
{
    /**
     * @param  string  $configName
     * @param  string  $clientType
     * @param  string  $userId
     * @return array
     */
    public static function config(string $configName, string $clientType, $userId = 'UnLoginUser'): array
    {
        $status = Geetest::senseBot($configName)->preProcess([
            'user_id' => $userId,
            'client_type' => $clientType,
            'ip_address' => request()->ip(),
        ]);
        session()->put('gtserver', $status);
        session()->put('user_id', $userId);

        return Geetest::senseBot($configName)->getResponse();
    }

    /**
     * @param  string  $configName
     * @param  array  $data
     * @param  string  $clientType
     * @param  string  $userId
     */
    public static function validate(string $configName, array $data, string $clientType, $userId = 'UnLoginUser')
    {
        [$challenge, $validate, $secCode] = array_values($data);
        if (!$challenge || !$validate || !$secCode) {
            throw new HttpException(400, trans('extension::auth.geetest_failed'));
        }

        if (1 == session()->get('gtserver')) {
            $result = Geetest::senseBot($configName)->successValidate($challenge, $validate, $secCode, [
                'user_id' => $userId,
                'client_type' => $clientType,
                'ip_address' => request()->ip(),
            ]);
        } else {
            $result = Geetest::senseBot($configName)->failValidate($challenge, $validate, $secCode);
        }

        if (false === $result) {
            throw new HttpException(400, trans('extension::auth.geetest_failed'));
        }
    }
}
