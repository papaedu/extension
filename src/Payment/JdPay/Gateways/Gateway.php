<?php

namespace Papaedu\Extension\Payment\JdPay\Gateways;

use Illuminate\Support\Facades\Http;
use Papaedu\Extension\Payment\JdPay\Exception\InvalidRequestException;
use Papaedu\Extension\Payment\JdPay\Support\Sign;
use Papaedu\Extension\Payment\JdPay\Support\TDES;
use Papaedu\Extension\Payment\JdPay\Support\XML;

abstract class Gateway implements GatewayInterface
{
    protected array $config;

    protected array $response = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @throws \Papaedu\Extension\Payment\JdPay\Exception\InvalidRequestException
     */
    public function pay(array $payload): array
    {
        $payload['sign'] = (new Sign($this->config))->encryptByXML($payload);

        $result = [
            'version' => $payload['version'],
            'merchant' => $payload['merchant'],
            'encrypt' => $this->tdes($payload),
        ];

        $response = Http::withBody(XML::encode($result), 'application/xml;charset=utf-8')->post($this->endpoint);
        if (! $response->ok()) {
            throw new InvalidRequestException('请求异常，请稍后重试');
        }

        return $this->handleResponse($response);
    }

    protected function tdes($params): string
    {
        if (is_array($params)) {
            $params = XML::encode($params);
        }
        $hex = (new TDES())->encrypt2Hex($params, base64_decode($this->config['tdes_key']));

        return base64_encode($hex);
    }

    /**
     * @param  \Illuminate\Http\Client\Response  $response
     * @return array
     */
    public function handleResponse($response): array
    {
        return [];
    }
}
