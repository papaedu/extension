<?php

namespace Papaedu\Extension;

use BenSampo\Enum\Enum;
use Illuminate\Support\ServiceProvider as LaravelProvider;
use Overtrue\EasySms\EasySms;
use Papaedu\Extension\Auth\Console\ControllerCommand;
use Papaedu\Extension\Filesystem\Disk;
use Papaedu\Extension\Support\Extend;
use Papaedu\Extension\UmengPush\UmengPush;
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
        $this->registerEnums();
        $this->registerChannels();
        $this->registerCommands();
    }

    private function registerConfig()
    {
        $source = realpath(__DIR__.'/config.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('extension.php')], 'extension-config');
        }

        $this->mergeConfigFrom($source, 'extension');
    }

    private function registerEnums()
    {
        Enum::macro('toEnumArray', function ($removeNone = true) {
            $array = self::toArray();
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
            $array = self::toArray();
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

        $this->app['validator']->extend('mobile', function ($attributes, $value, $parameters, $validator) {
            return Extend::isMobile($value);
        }, ':attribute格式错误');

        $this->app['validator']->extend('password_strength', function ($attributes, $value, $parameters, $validator) {
            return Extend::passwordStrength($value);
        }, ':attribute必须包含数字，且必须包含字母或其它符号（!@_#$%^&*()-+=,.?）');

        $this->app['validator']->extend('multiple_of', function ($attributes, $value, $parameters, $validator) {
            return (new MultipleOf($parameters))->passes($attributes, $value);
        }, ':attribute格式错误');

        $this->app['validator']->extend('captcha', function ($attributes, $value, $parameters, $validator) {
            return (new Captcha($parameters, $validator))->passes($attributes, $value);
        }, ':attribute错误');

        $this->app['validator']->extendImplicit('required_multiple_if', function ($attributes, $value, $parameters, $validator) {
            return (new RequiredMultiIf($parameters, $validator))->passes($attributes, $value);
        }, ':attribute不能为空');
    }
}
