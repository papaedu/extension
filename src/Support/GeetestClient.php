<?php

namespace Papaedu\Extension\Support;

use Papaedu\Extension\Facades\Geetest;

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
     * @param  string  $appName
     * @param  string  $clientType
     * @param  string  $userId
     * @return bool
     */
    public static function validate(string $appName, string $clientType, $userId = 'UnLoginUser')
    {
        [$geetestChallenge, $geetestValidate, $geetestSeccode] = array_values(request()->only('geetest_challenge', 'geetest_validate', 'geetest_seccode'));

        if (1 == session()->get('gtserver')) {
            return Geetest::config($appName)->successValidate($geetestChallenge, $geetestValidate, $geetestSeccode, [
                'user_id' => $userId,
                'client_type' => $clientType,
                'ip_address' => request()->ip(),
            ]);
        } else {
            return Geetest::config($appName)->failValidate($geetestChallenge, $geetestValidate, $geetestSeccode);
        }
    }
}
