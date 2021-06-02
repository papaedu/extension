<?php

namespace Papaedu\Extension;

use BenSampo\Enum\Enum;
use Illuminate\Support\ServiceProvider as LaravelProvider;
use Overtrue\EasySms\EasySms;
use Papaedu\Extension\Auth\Console\ControllerCommand;
use Papaedu\Extension\Filesystem\Disk;
use Papaedu\Extension\Support\Extend;
use Papaedu\Extension\UmengPush\UmengPush;
use Papaedu\Extension\Validation\Rules\AllStringMax;
use Papaedu\Extension\Validation\Rules\AuthCaptcha;
use Papaedu\Extension\Validation\Rules\Captcha;
use Papaedu\Extension\Validation\Rules\MultipleOf;
use Papaedu\Extension\Validation\Rules\RequiredMultiIf;

class ServiceProvider extends LaravelProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerGeetestConfig();
        $this->registerTencentCloudConfig();

        $this->registerEnums();
        $this->registerChannels();
        $this->registerCommands();
        $this->registerMigrations();
    }

    private function registerConfig()
    {
        $source = realpath(__DIR__.'/config.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('extension.php')], 'extension-config');
        }

        $this->mergeConfigFrom($source, 'extension');
    }

    private function registerGeetestConfig()
    {
        $source = realpath(__DIR__.'/config-geetest.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('geetest.php')], 'extension-config-geetest');
        }

        $this->mergeConfigFrom($source, 'geetest');
    }

    private function registerTencentCloudConfig()
    {
        $source = realpath(__DIR__.'/config-tencent-cloud.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('tencent-cloud.php')], 'extension-config-tencent-cloud');
        }

        $this->mergeConfigFrom($source, 'tencent-cloud');
    }

    private function registerEnums()
    {
        Enum::macro('toEnumArray', function ($removeNone = true) {
            $array = self::asArray();
            $enumArray = [];

            if ($removeNone) {
                unset($array['None']);
            }

            foreach ($array as $value) {
                $enumArray[] = [
                    'key' => $value,
                    'value' => self::getDescription($value),
                ];
            }

            return $enumArray;
        });

        Enum::macro('toEnumValueArray', function ($removeNone = true) {
            $array = self::asArray();
            $enumArray = [];

            if ($removeNone) {
                unset($array['None']);
            }

            foreach ($array as $value) {
                $enumArray[] = [
                    'key' => self::getDescription($value),
                    'value' => self::getDescription($value),
                ];
            }

            return $enumArray;
        });

        Enum::macro('getKeyValue', function ($enumValue) {
            $enum = self::getInstance($enumValue);

            return [
                'key' => $enum->value,
                'value' => $enum->description,
            ];
        });
    }

    private function registerChannels()
    {
        $this->app->singleton(EasySms::class, function ($app) {
            return new EasySms($app['config']['easysms']);
        });

        $this->app->singleton(UmengPush::class, function ($app) {
            return new UmengPush($app['config']['umeng']);
        });
    }

    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ControllerCommand::class,
            ]);
        }
    }

    private function registerMigrations()
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
    public function boot()
    {
        $this->bootValidationTranslation();
        $this->bootValidators();
    }

    private function bootValidationTranslation()
    {
        $source = realpath(__DIR__.'/../resources/lang');
        if ($this->app->runningInConsole()) {
            $this->publishes([$source => resource_path('lang/vendor/extension')]);
        }

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'extension');
    }

    private function bootValidators()
    {
        $this->app['validator']->extend('image_exists', function ($attribute, $value, $parameters, $validator) {
            return Disk::image()->exists($value);
        }, ':attribute不存在或上传失败');

        $this->app['validator']->extend('audio_exists', function ($attribute, $value, $parameters, $validator) {
            return Disk::audio()->exists($value);
        }, ':attribute不存在或上传失败');

        $this->app['validator']->extend('file_exists', function ($attribute, $value, $parameters, $validator) {
            return Disk::file()->exists($value);
        }, ':attribute不存在或上传失败');

        $this->app['validator']->extend('password_strength', function ($attributes, $value, $parameters, $validator) {
            return Extend::passwordStrength($value);
        }, ':attribute必须包含数字、字母及符号，长度在8-16位');

        $this->app['validator']->extend(
            'password_strength_low',
            function ($attributes, $value, $parameters, $validator) {
                return Extend::passwordStrengthLow($value);
            },
            ':attribute必须包含数字与字母，长度在8-16位'
        );

        $this->app['validator']->extend('multiple_of', function ($attributes, $value, $parameters, $validator) {
            return (new MultipleOf($parameters))->passes($attributes, $value);
        }, ':attribute格式错误');

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
