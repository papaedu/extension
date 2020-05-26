<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\ServiceProvider;
use Overtrue\EasySms\EasySms;

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
