<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\ServiceProvider;
use Papaedu\Extension\TencentCloud\Tim\TimClient;

class TencentCloudServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $apps = [
            'tim' => TimClient::class,
        ];

        foreach ($apps as $name => $class) {
            if (empty(config("tencent_cloud.{$name}"))) {
                continue;
            }

            if (!empty(config("tencent_cloud.{$name}.sdk_app_id"))) {
                $accounts = [
                    'default' => config("tencent_cloud.{$name}"),
                ];
                config(["tencent_cloud.{$name}.default" => $accounts['default']]);
            } else {
                $accounts = config("tencent_cloud.{$name}");
            }

            foreach ($accounts as $account => $config) {
                $this->app->singleton("tencent_cloud.{$name}.{$account}", function ($app) use ($config, $class) {
                    return new $class($config);
                });
            }
            $this->app->alias("tencent_cloud.{$name}.default", "tencent_cloud.{$name}");
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
