<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;
use Papaedu\Extension\Payment\ApplePay\ApplePay;
use Papaedu\Extension\Payment\JdPay\JdPay;

class Payment extends Facade
{
    /**
     * @param  string  $name
     * @return \Papaedu\Extension\Payment\JdPay\JdPay
     */
    public static function jdpay(string $name = ''): JdPay
    {
        return $name ? app('payment.jdpay.'.$name) : app('payment.jdpay');
    }

    /**
     * @return \Papaedu\Extension\Payment\ApplePay\ApplePay
     */
    public static function applePay(): ApplePay
    {
        return app('payment.apple_pay');
    }
}
