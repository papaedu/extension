<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\ServiceProvider;
use Papaedu\Extension\Geetest\OnePass;
use Papaedu\Extension\Geetest\SenseBot;

class GeetestServiceProvider extends ServiceProvider
{
    use MultipleAccountsTrait;

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $apps = [
            'sense_bot' => [
                'name' => SenseBot::class,
                'must_key' => 'app_id',
            ],
            'one_pass' => [
                'name' => OnePass::class,
                'must_key' => 'app_id',
            ],
        ];

        $this->singletonMultipleAccountsApp('geetest', $apps);
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
