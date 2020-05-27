<?php

namespace Papaedu\Extension\Traits;

use Papaedu\Extension\Facades\Geetest;

trait GeetestTrait
{
    public function captcha(string $clientType, $userId = 'UnLoginUser')
    {
        $status = Geetest::preProcess([
            'user_id' => $userId,
            'client_type' => $clientType,
            'ip_address' => request()->ip(),
        ]);
        session()->put('gtserver', $status);
        session()->put('user_id', $userId);

        return Geetest::getResponse();
    }

    public function verify(string $clientType, $userId = 'UnLoginUser')
    {
        [$geetestChallenge, $geetestValidate, $geetestSeccode] = array_values(request()->only('geetest_challenge', 'geetest_validate', 'geetest_seccode'));

        if (1 == session()->get('gtserver')) {
            return Geetest::successValidate($geetestChallenge, $geetestValidate, $geetestSeccode, [
                'user_id' => $userId,
                'client_type' => $clientType,
                'ip_address' => request()->ip(),
            ]);
        } else {
            return Geetest::failValidate($geetestChallenge, $geetestValidate, $geetestSeccode);
        }
    }
}
