<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\ServiceProvider;
use Papaedu\Extension\TencentCloud\Tim\TimClient;
use Papaedu\Extension\TencentCloud\Tiw\TiwClient;
use Papaedu\Extension\TencentCloud\Trtc\TrtcClient;
use Papaedu\Extension\TencentCloud\Vod\VodClient;

class TencentCloudServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSdkAppId();
        $this->registerSecretId();
    }

    protected function registerSdkAppId()
    {
        $apps = [
            'tim' => TimClient::class,
        ];

        foreach ($apps as $name => $class) {
            if (empty($config = config("tencent-cloud.{$name}"))) {
                continue;
            }

            $this->app->singleton("tencent_cloud.{$name}", fn ($app) => new $class($config));
        }
    }

    protected function registerSecretId()
    {
        $apps = [
            'tiw' => TiwClient::class,
            'trtc' => TrtcClient::class,
            'vod' => VodClient::class,
        ];

        foreach ($apps as $name => $class) {
            if (empty($config = config("tencent-cloud.{$name}"))) {
                continue;
            }

            $config['secret_id'] ?? $config['secret_id'] = config('tencent-cloud.secret_id');
            $config['secret_key'] ?? $config['secret_key'] = config('tencent-cloud.secret_key');
            $config['region'] ?? $config['region'] = config('tencent-cloud.region');

            $this->app->singleton("tencent_cloud.{$name}", fn ($app) => new $class($config));
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
