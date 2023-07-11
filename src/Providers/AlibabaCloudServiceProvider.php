<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\ServiceProvider;
use Papaedu\Extension\AlibabaCloud\Green\GreenClient;
use Papaedu\Extension\AlibabaCloud\Sts\StsClient;

class AlibabaCloudServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $apps = [
            'green' => GreenClient::class,
            'sts' => StsClient::class,
        ];

        foreach ($apps as $name => $class) {
            if (empty($config = config("alibaba-cloud.{$name}"))) {
                continue;
            }

            $config['uid'] ??= config('alibaba-cloud.uid');
            $config['access_key_id'] ??= config('alibaba-cloud.access_key_id');
            $config['access_key_secret'] ??= config('alibaba-cloud.access_key_secret');
            $config['region_id'] ??= config('alibaba-cloud.region_id');

            $this->app->singleton("alibaba_cloud.{$name}", fn ($app) => new $class($config));
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
