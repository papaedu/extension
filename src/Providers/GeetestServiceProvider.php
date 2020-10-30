<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\ServiceProvider;
use Papaedu\Extension\Geetest\Geetest;

class GeetestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $configs = config('geetest');
        foreach ($configs as $name => $config) {
            $this->app->singleton("geetest.{$name}", function ($app) use ($config) {
                return new Geetest($config);
            });
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
