<?php

namespace Papaedu\Extension\Payment\JdPay;

use Illuminate\Support\Str;
use Papaedu\Extension\Exceptions\InvalidArgumentException;
use Papaedu\Extension\Payment\JdPay\Gateways\GatewayInterface;

class JdPay
{
    protected array $config;

    protected array $payload;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->payload = [
            'version' => 'V2.0',
            'merchant' => $config['merchant'],
            'tradeTime' => date('YmdHis'),
            'currency' => 'CNY',
        ];
    }

    public function __call(string $method, $params)
    {
        return $this->pay($method, ...$params);
    }

    public function pay(string $gateway, array $params = [])
    {
        $this->payload = array_merge($this->payload, $params);

        $gateway = __NAMESPACE__.'\\Gateways\\'.Str::studly($gateway).'Gateway';

        if (class_exists($gateway)) {
            $app = new $gateway($this->config);
            if ($app instanceof GatewayInterface) {
                return $app->pay(array_filter($this->payload));
            }
        }

        throw new InvalidArgumentException('Gateway not exists.');
    }
}
