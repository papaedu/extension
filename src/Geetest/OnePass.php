<?php

namespace Papaedu\Extension\Geetest;

use Illuminate\Support\Facades\Http;
use Papaedu\Extension\Exceptions\BadResponseException;
use Papaedu\Extension\Exceptions\HttpException;

class OnePass
{
    protected array $config;

    private string $domain = 'https://onelogin.geetest.com/';

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param  string  $processId
     * @param  string  $authCode
     * @param  string  $token
     * @return string
     * @throws \Papaedu\Extension\Exceptions\BadResponseException
     * @throws \Papaedu\Extension\Exceptions\HttpException
     */
    public function checkPhone(string $processId, string $authCode, string $token): string
    {
        $data = [
            'process_id' => $processId,
            'token' => $token,
            'timestamp' => intval(microtime(true) * 1000),
        ];
        if ($authCode) {
            $data['authcode'] = $authCode;
        }
        $sign = hash_hmac('sha256', $this->config['app_id'].'&&'.$data['timestamp'], $this->config['key'], true);
        $data['sign'] = bin2hex($sign);

        $response = Http::timeout(1)->asJson()->post($this->domain.'check_phone', $data);
        if ($response->status() != 200) {
            throw new HttpException($response->body(), $response->toPsrResponse(), $response->status());
        }

        $result = $response->json();
        if ($result['status'] != 200) {
            throw new BadResponseException($result['error_msg'], $result['status']);
        }

        return $result['result'];
    }
}
