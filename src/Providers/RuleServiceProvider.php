<?php

namespace Papaedu\Extension\Providers;

use App\Rules\MultiUnique;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Papaedu\Extension\Rules\MultipleOf;
use Papaedu\Extension\Rules\RequiredMultiIf;
use Papaedu\Extension\Support\Disks\Disk;
use Papaedu\Extension\Support\Extend;

class RuleServiceProvider extends ServiceProvider
{
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

        Validator::extend('password_strength', function ($attributes, $value, $parameters, $validator) {
            return Extend::passwordStrength($value);
        }, ':attribute必须包含数字，且必须包含字母或其它符号（!@_#$%^&*()-+=,.?）');

        Validator::extend('multiple_of', function ($attributes, $value, $parameters, $validator) {
            return (new MultipleOf($parameters))->passes($attributes, $value);
        }, ':attribute格式错误');

        Validator::extendImplicit('required_multiple_if', function ($attributes, $value, $parameters, $validator) {
            return (new RequiredMultiIf($parameters, $validator))->passes($attributes, $value);
        }, ':attribute不能为空');
    }
}
