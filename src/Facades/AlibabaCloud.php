<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;
use OSS\OssClient;
use Papaedu\Extension\AlibabaCloud\Green\GreenClient;
use Papaedu\Extension\AlibabaCloud\Sts\StsClient;

class AlibabaCloud extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'alibaba_cloud.oss';
    }

    public static function oss(): OssClient
    {
        return app('alibaba_cloud.oss');
    }

    public static function green(): GreenClient
    {
        return app('alibaba_cloud.green');
    }

    public static function sts(): StsClient
    {
        return app('alibaba_cloud.sts');
    }
}
