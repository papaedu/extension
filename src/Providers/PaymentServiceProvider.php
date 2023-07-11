<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\ServiceProvider;
use Papaedu\Extension\Payment\ApplePay\ApplePay;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('payment.apple_pay', fn () => new ApplePay());
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
