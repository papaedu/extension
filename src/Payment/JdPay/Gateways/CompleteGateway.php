<?php

namespace Papaedu\Extension\Payment\JdPay\Gateways;

use Papaedu\Extension\Payment\JdPay\Support\Sign;

class CompleteGateway
{
    private $parameters;

    public function purchase($contents): bool
    {
        $sign = new Sign();
        if ($sign->validate($contents)) {
            $result = $sign->getResult();
            if ($result['result']['desc'] == 'success' && $result['status'] == 2) {
                $this->parameters = $sign->getResult();

                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
