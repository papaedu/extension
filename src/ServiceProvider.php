<?php

namespace Papaedu\Extension;

use Illuminate\Support\ServiceProvider as LaravelProvider;
use Illuminate\Validation\Rules\Password;
use Overtrue\EasySms\EasySms;
use Papaedu\Extension\UmengPush\UmengPush;
use Papaedu\Extension\Validation\Rules\AllStringMax;
use Papaedu\Extension\Validation\Rules\AuthCaptcha;
use Papaedu\Extension\Validation\Rules\Captcha;
use Papaedu\Extension\Validation\Rules\Filesystem\AudioExistsOfAliyun;
use Papaedu\Extension\Validation\Rules\Filesystem\AudioExistsOfQiniu;
use Papaedu\Extension\Validation\Rules\Filesystem\FileExistsOfAliyun;
use Papaedu\Extension\Validation\Rules\Filesystem\FileExistsOfQiniu;
use Papaedu\Extension\Validation\Rules\Filesystem\ImageExistsOfAliyun;
use Papaedu\Extension\Validation\Rules\Filesystem\ImageExistsOfQiniu;
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
        $this->registerMigrations();
    }

    protected function setupConfig(): void
    {
        $sources = [];
        array_map(function ($item) use (&$sources) {
            $sources[$item] = realpath(__DIR__."/../config/{$item}.php");
        }, [
            'extension',
            'alibaba-cloud',
            'tencent-cloud',
            'gether-cloud',
            'geetest',
            'payment',
        ]);

        if ($this->app->runningInConsole()) {
            foreach ($sources as $name => $source) {
                $this->publishes([$source => config_path($name.'.php')], 'papaedu-extension');
            }
        }

        foreach ($sources as $name => $source) {
            $this->mergeConfigFrom($source, $name);
        }
    }

    protected function registerChannels(): void
    {
        $this->app->singleton(EasySms::class, function ($app) {
            return new EasySms($app['config']['easysms']);
        });

        $this->app->singleton(GetherCloudSms::class, function ($app) {
            return new GetherCloudSms($app['config']['gether-cloud']['sms']);
        });

        $this->app->singleton(UmengPush::class, function ($app) {
            return new UmengPush($app['config']['umeng']);
        });
    }

    protected function registerMigrations(): void
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

    protected function bootValidationTranslation(): void
    {
        $source = __DIR__.'/../resources/lang';
        if ($this->app->runningInConsole()) {
            $this->publishes([$source => resource_path('lang/vendor/extension')]);
        }

        $this->loadTranslationsFrom($source.'/', 'extension');
    }

    protected function bootValidators(): void
    {
        // Common
        $this->app['validator']->extend('image_exists', ImageExistsOfQiniu::class.'@passes');
        $this->app['validator']->extend('audio_exists', AudioExistsOfQiniu::class.'@passes');
        $this->app['validator']->extend('file_exists', FileExistsOfQiniu::class.'@passes');

        // Aliyun
        $this->app['validator']->extend('aliyun_image_exists', ImageExistsOfAliyun::class.'@passes');
        $this->app['validator']->extend('aliyun_audio_exists', AudioExistsOfAliyun::class.'@passes');
        $this->app['validator']->extend('aliyun_file_exists', FileExistsOfAliyun::class.'@passes');

        // Qiniu
        $this->app['validator']->extend('qiniu_image_exists', ImageExistsOfQiniu::class.'@passes');
        $this->app['validator']->extend('qiniu_audio_exists', AudioExistsOfQiniu::class.'@passes');
        $this->app['validator']->extend('qiniu_file_exists', FileExistsOfQiniu::class.'@passes');

        // Captcha
        $this->app['validator']->extend('auth_captcha', AuthCaptcha::class.'@validate');
        $this->app['validator']->extend('captcha', Captcha::class.'@validate');

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
