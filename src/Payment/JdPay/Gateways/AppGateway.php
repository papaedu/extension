<?php

namespace Papaedu\Extension\Payment\JdPay\Gateways;

use Papaedu\Extension\Payment\JdPay\Support\Sign;

class AppGateway extends Gateway
{
    protected string $endpoint = 'https://paygate.jd.com/service/uniorder';

    /**
     * @param  \Illuminate\Http\Client\Response  $response
     * @return array
     */
    public function handleResponse($response): array
    {
        $sign = new Sign($this->config);
        if ($sign->validate($response->body())) {
            $result = $sign->getResult();
            $signData = [
                'merchant' => $this->config['merchant'],
                'orderId' => $result['orderId'],
                'key' => $this->config['md5_key'],
            ];

            return [
                'order_id' => $result['orderId'],
                'sign_data' => md5(urldecode(http_build_query($signData))),
            ];
        }

        return [];
    }
}
