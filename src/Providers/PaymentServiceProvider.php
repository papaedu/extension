<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\ServiceProvider;
use Yansongda\Pay\Pay;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $apps = [
            'alipay',
            'wechat',
        ];

        foreach ($apps as $name) {
            if (empty(config("payment.{$name}"))) {
                continue;
            }

            if (!empty(config("payment.{$name}.app_id"))) {
                $accounts = [
                    'default' => config("payment.{$name}"),
                ];
                config(["payment.{$name}.default" => $accounts['default']]);
            } else {
                $accounts = config("payment.{$name}");
            }

            foreach ($accounts as $account => $config) {
                $this->app->singleton("payment.{$name}.{$account}", function ($app) use ($config, $name) {
                    return Pay::{$name}($config);
                });
            }
            $this->app->alias("payment.{$name}.default", "payment.{$name}");
        }
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
