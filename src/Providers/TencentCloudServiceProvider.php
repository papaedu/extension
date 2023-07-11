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
    public function register(): void
    {
        $this->registerSdkAppId();
        $this->registerSecretId();
    }

    protected function registerSdkAppId(): void
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

    protected function registerSecretId(): void
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

            if (! isset($config['secret_id'])) {
                $config['secret_id'] = config('tencent-cloud.secret_id');
            }
            if (! isset($config['secret_key'])) {
                $config['secret_key'] = config('tencent-cloud.secret_key');
            }
            if (! isset($config['region'])) {
                $config['region'] = config('tencent-cloud.region');
            }

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
