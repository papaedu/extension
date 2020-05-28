<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\ServiceProvider;
use Overtrue\EasySms\EasySms;
use Papaedu\Extension\UmengPush\UmengPush;

class ChannelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EasySms::class, function ($app) {
            return new EasySms($app['config']['easysms']);
        });

        $this->app->singleton(UmengPush::class, function ($app) {
            return new UmengPush($app['config']['umeng']);
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
