<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;
use Yansongda\Pay\Gateways\Alipay;
use Yansongda\Pay\Gateways\Wechat;

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
     * @return \Yansongda\Pay\Gateways\Alipay
     */
    public static function alipay(string $name = ''): Alipay
    {
        return $name ? app('payment.alipay.'.$name) : app('payment.alipay');
    }

    /**
     * @param  string  $name
     * @return \Yansongda\Pay\Gateways\Wechat
     */
    public static function wechat(string $name = ''): Wechat
    {
        return $name ? app('payment.wechat.'.$name) : app('payment.wechat');
    }
}
