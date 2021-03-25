<?php

namespace Papaedu\Extension\Geetest;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OnePass
{
    /**
     * @var array
     */
    private array $config;

    /**
     * @var string
     */
    private string $domain = 'https://onelogin.geetest.com/';

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * 验证一键登录信息
     *
     * @param  string  $processId
     * @param  string  $authCode
     * @param  string  $token
     * @return false|string
     */
    public function oneLoginCheckPhone(string $processId, string $authCode, string $token)
    {
        $data = [
            'process_id' => $processId,
            'token' => $token,
            'timestamp' => intval(microtime(true) * 1000),
        ];
        if ($authCode) {
            $data['authcode'] = $authCode;
        }
        $sign = hash_hmac(
            'sha256',
            "{$this->config['app_id']}&&{$data['timestamp']}",
            $this->config['key'],
            true
        );
        $data['sign'] = bin2hex($sign);

        $response = Http::timeout(1)->asJson()->post($this->domain.'check_phone', $data);
        if (200 != $response->status()) {
            return false;
        }

        $result = $response->json();
        if (200 != $result['status']) {
            Log::warning('OnePass', $result);
            return false;
        }

        return $result['result'] ?? '';
    }
}
