<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\ServiceProvider;
use Papaedu\Extension\TencentCloud\Cos\CosClient;
use Papaedu\Extension\TencentCloud\Tim\TimClient;
use Papaedu\Extension\TencentCloud\Tiw\TiwClient;
use Papaedu\Extension\TencentCloud\Trtc\TrtcClient;
use Papaedu\Extension\TencentCloud\Vod\VodClient;

class TencentCloudServiceProvider extends ServiceProvider
{
    use MultipleAccountsTrait;

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
            'tim' => [
                'name' => TimClient::class,
                'must_key' => 'sdk_app_id',
            ],
        ];

        $this->singletonMultipleAccountsApp('tencent-cloud', $apps);
    }

    protected function registerSecretId(): void
    {
        $apps = [
            'cos' => [
                'name' => CosClient::class,
                'must_key' => 'bucket',
            ],
            'tiw' => [
                'name' => TiwClient::class,
                'must_key' => 'sdk_app_id',
            ],
            'trtc' => [
                'name' => TrtcClient::class,
                'must_key' => 'sdk_app_id',
            ],
            'vod' => [
                'name' => VodClient::class,
                'must_key' => 'sub_app_id',
            ],
        ];

        $this->singletonMultipleAccountsApp('tencent-cloud', $apps, function (&$config) {
            if (! isset($config['secret_id'])) {
                $config['secret_id'] = config('tencent-cloud.secret_id');
            }
            if (! isset($config['secret_key'])) {
                $config['secret_key'] = config('tencent-cloud.secret_key');
            }
            if (! isset($config['region'])) {
                $config['region'] = config('tencent-cloud.region');
            }
        });
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
