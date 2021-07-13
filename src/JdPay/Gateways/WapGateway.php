<?php

namespace Papaedu\Extension\JdPay\Gateways;

use Papaedu\Extension\Jdpay\Support\Sign;

class WapGateway extends Gateway
{
    protected string $endpoint = 'https://h5pay.jd.com/jdpay/saveOrder';

    public function pay(array $payload): array
    {
        $payload['sign'] = (new Sign($this->config))->encryptByXML($payload);

        foreach ($payload as $key => &$value) {
            if (! in_array($key, ['sign', 'merchant', 'version'])) {
                $value = $this->tdes(strval($value));
            }
        }

        return $payload;
    }
}
