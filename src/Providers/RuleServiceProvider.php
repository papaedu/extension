<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Papaedu\Extension\Support\Disks\Disk;
use Papaedu\Extension\Support\Extend;

class RuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('image_exists', function ($attribute, $value, $parameters, $validator) {
            return Disk::image()->exists($value);
        }, ':attribute不存在或上传失败');

        Validator::extend('audio_exists', function ($attribute, $value, $parameters, $validator) {
            return Disk::audio()->exists($value);
        }, ':attribute不存在或上传失败');

        Validator::extend('file_exists', function ($attribute, $value, $parameters, $validator) {
            return Disk::file()->exists($value);
        }, ':attribute不存在或上传失败');

        Validator::extend('mobile', function ($attributes, $value, $parameters, $validator) {
            return Extend::isMobile($value);
        }, ':attribute格式错误');
    }
}
