<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\ServiceProvider;
use Papaedu\Extension\Geetest\OnePass;
use Papaedu\Extension\Geetest\SenseBot;

class GeetestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $apps = [
            'sense_bot' => SenseBot::class,
            'one_pass' => OnePass::class,
        ];

        foreach ($apps as $name => $class) {
            if (empty(config("geetest.{$name}"))) {
                continue;
            }

            if (!empty(config("geetest.{$name}.app_id"))) {
                $accounts = [
                    'default' => config("geetest.{$name}"),
                ];
                config(["geetest.{$name}.default" => $accounts['default']]);
            } else {
                $accounts = config("geetest.{$name}");
            }

            foreach ($accounts as $account => $config) {
                $this->app->singleton("geetest.{$name}.{$account}", function ($app) use ($config, $class) {
                    return new $class($config);
                });
            }
            $this->app->alias("geetest.{$name}.default", "geetest.{$name}");
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
