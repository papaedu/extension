<?php

namespace Papaedu\Extension;

use Illuminate\Support\ServiceProvider as LaravelProvider;
use Illuminate\Validation\Rules\Password;
use Overtrue\EasySms\EasySms;
use Papaedu\Extension\MediaLibrary\MediaLibrary;
use Papaedu\Extension\UmengPush\UmengPush;
use Papaedu\Extension\Validation\Rules\AllStringMax;
use Papaedu\Extension\Validation\Rules\AuthCaptcha;
use Papaedu\Extension\Validation\Rules\Captcha;
use Papaedu\Extension\Validation\Rules\RequiredMultiIf;

class ServiceProvider extends LaravelProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->setupConfig();

        $this->registerChannels();
//        $this->registerCommands();
        $this->registerMigrations();
    }

    protected function setupConfig()
    {
        $sources = [
            'extension' => realpath(__DIR__.'/../config/extension.php'),
            'alibaba-cloud' => realpath(__DIR__.'/../config/alibaba-cloud.php'),
            'tencent-cloud' => realpath(__DIR__.'/../config/tencent-cloud.php'),
            'geetest' => realpath(__DIR__.'/../config/geetest.php'),
            'payment' => realpath(__DIR__.'/../config/payment.php'),
        ];

        if ($this->app->runningInConsole()) {
            foreach ($sources as $name => $source) {
                $this->publishes([$source => config_path($name.'.php')], 'papaedu-extension');
            }
        }

        foreach ($sources as $name => $source) {
            $this->mergeConfigFrom($source, $name);
        }
    }

    protected function registerChannels()
    {
        $this->app->singleton(EasySms::class, function ($app) {
            return new EasySms($app['config']['easysms']);
        });

        $this->app->singleton(UmengPush::class, function ($app) {
            return new UmengPush($app['config']['umeng']);
        });
    }

    protected function registerMigrations()
    {
        $this->publishes([
            __DIR__.'/Database/Migrations/' => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootValidationTranslation();
        $this->bootValidators();

        Password::defaults(fn () => Password::min(8)->mixedCase()->numbers()->symbols());
    }

    protected function bootValidationTranslation()
    {
        $source = __DIR__.'/../resources/lang';
        if ($this->app->runningInConsole()) {
            $this->publishes([$source => resource_path('lang/vendor/extension')]);
        }

        $this->loadTranslationsFrom($source.'/', 'extension');
    }

    protected function bootValidators()
    {
        $this->app['validator']->extend(
            'image_exists',
            fn ($attribute, $value, $parameters, $validator) => MediaLibrary::image()->exists($value),
            ':attribute不存在或上传失败'
        );

        $this->app['validator']->extend(
            'audio_exists',
            fn ($attribute, $value, $parameters, $validator) => MediaLibrary::audio()->exists($value)
            , ':attribute不存在或上传失败'
        );

        $this->app['validator']->extend(
            'file_exists',
            fn ($attribute, $value, $parameters, $validator) => MediaLibrary::file()->exists($value),
            ':attribute不存在或上传失败'
        );

        $this->app['validator']->extend('captcha', Captcha::class.'@validate');
        $this->app['validator']->extend('auth_captcha', AuthCaptcha::class.'@validate');

        $this->app['validator']->extend('all_string_max', function ($attributes, $value, $parameters, $validator) {
            return (new AllStringMax($parameters))->passes($attributes, $value);
        }, ':attribute格式错误');

        $this->app['validator']->extendImplicit(
            'required_multiple_if',
            function ($attributes, $value, $parameters, $validator) {
                return (new RequiredMultiIf($parameters, $validator))->passes($attributes, $value);
            },
            ':attribute不能为空'
        );
    }
}
