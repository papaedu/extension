<?php

namespace Papaedu\Extension\Traits;

use Papaedu\Extension\Facades\Geetest;

trait GeetestTrait
{
    /**
     * @param  string  $appName
     * @param  string  $clientType
     * @param  string  $userId
     * @return array
     */
    public function captchaGeetest(string $appName, string $clientType, $userId = 'UnLoginUser')
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
    public function validateGeetest(string $appName, string $clientType, $userId = 'UnLoginUser')
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
