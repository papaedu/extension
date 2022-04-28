<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\ServiceProvider;
use Papaedu\Extension\Payment\ApplePay\ApplePay;
use Papaedu\Extension\Payment\JdPay\JdPay;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $apps = [
//            'jdpay',
//        ];
//
//        foreach ($apps as $name) {
//            if (empty(config("payment.{$name}"))) {
//                continue;
//            }
//
//            if (! empty(config("payment.{$name}.app_id"))) {
//                $accounts = [
//                    'default' => config("payment.{$name}"),
//                ];
//                config(["payment.{$name}.default" => $accounts['default']]);
//            } else {
//                $accounts = config("payment.{$name}");
//            }
//
//            foreach ($accounts as $account => $config) {
//                $this->app->singleton("payment.{$name}.{$account}", function ($app) use ($config, $name) {
//                    if ($name == 'jdpay') {
//                        return new JdPay($config);
//                    } else {
//                        return Pay::{$name}($config);
//                    }
//                });
//            }
//            $this->app->alias("payment.{$name}.default", "payment.{$name}");
//        }

        $this->app->singleton('payment.apple_pay', fn () => new ApplePay());
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
