<?php

namespace Papaedu\Extension\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Papaedu\Extension\Support\Disks\Disk;

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
        }, '图片不存在或上传失败');

        Validator::extend('audio_exists', function ($attribute, $value, $parameters, $validator) {
            return Disk::audio()->exists($value);
        }, '音频不存在或上传失败');

        Validator::extend('file_exists', function ($attribute, $value, $parameters, $validator) {
            return Disk::file()->exists($value);
        }, '文件不存在或上传失败');
    }
}
