<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;
use Papaedu\Extension\Payment\ApplePay\ApplePay;
use Papaedu\Extension\Payment\JdPay\JdPay;
use Yansongda\Pay\Provider\Alipay;
use Yansongda\Pay\Provider\Wechat;

class Payment extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'payment.alipay';
    }

    /**
     * @param  string  $name
     * @return \Yansongda\Pay\Provider\Alipay
     */
    public static function alipay(string $name = ''): Alipay
    {
        return $name ? app('payment.alipay.'.$name) : app('payment.alipay');
    }

    /**
     * @param  string  $name
     * @return \Yansongda\Pay\Provider\Wechat
     */
    public static function wechat(string $name = ''): Wechat
    {
        return $name ? app('payment.wechat.'.$name) : app('payment.wechat');
    }

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
