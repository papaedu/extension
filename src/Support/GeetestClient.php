<?php

namespace Papaedu\Extension\Support;

use Papaedu\Extension\Facades\Geetest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GeetestClient
{
    /**
     * @param  string  $appName
     * @param  string  $clientType
     * @param  string  $userId
     * @return array
     */
    public static function config(string $appName, string $clientType, $userId = 'UnLoginUser')
    {
        $status = Geetest::config($appName)->preProcess([
            'user_id' => $userId,
            'client_type' => $clientType,
            'ip_address' => request()->ip(),
        ]);
        session()->put('gtserver', $status);
        session()->put('user_id', $userId);

        return Geetest::config($appName)->getResponse();
    }

    /**
     * @param  array  $data
     * @param  string  $appName
     * @param  string  $clientType
     * @param  string  $userId
     */
    public static function validate(array $data, string $appName, string $clientType, $userId = 'UnLoginUser')
    {
        [$challenge, $validate, $secCode] = array_values($data);
        if (!$challenge || !$validate || !$secCode) {
            throw new HttpException(400, trans('extension::auth.geetest_failed'));
        }

        if (1 == session()->get('gtserver')) {
            $result = Geetest::config($appName)->successValidate($challenge, $validate, $secCode, [
                'user_id' => $userId,
                'client_type' => $clientType,
                'ip_address' => request()->ip(),
            ]);
        } else {
            $result = Geetest::config($appName)->failValidate($challenge, $validate, $secCode);
        }

        if (false === $result) {
            throw new HttpException(400, trans('extension::auth.geetest_failed'));
        }
    }
}
