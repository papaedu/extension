<?php

namespace Papaedu\Extension\Captcha\Client;

use Papaedu\Extension\Facades\Geetest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GeetestClient
{
    public function getSenseBotConfig(string $configName, string $clientType, string $userId = 'UnLoginUser'): array
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

    public function validateSenseBot(string $configName, array $data, string $clientType, string $userId = 'UnLoginUser'): void
    {
        [$challenge, $validate, $secCode] = array_values($data);
        if (! $challenge || ! $validate || ! $secCode) {
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
