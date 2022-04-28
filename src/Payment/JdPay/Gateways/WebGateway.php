<?php

namespace Papaedu\Extension\Payment\JdPay\Gateways;

use Papaedu\Extension\Payment\JdPay\Support\Sign;

class WebGateway extends Gateway
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

            return [
                'qr_code_url' => $result['qrCode'],
            ];
        }

        return [];
    }

    /**
     * @throws Exception\InvalidRequestException
     */
    protected function validateParameters()
    {
        $this->validate(
            'version',
            'merchant',
            'tradeNum',
            'tradeName',
            'tradeTime',
            'amount',
            'orderType',
            'currency',
            'notifyUrl'
        );
    }

    protected function sign($parameters)
    {
        $sign = new Sign();

        return $sign->encryptByXML($parameters);
    }
}
