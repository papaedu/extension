<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;
use Papaedu\Extension\AlibabaCloud\Sts\StsClient;

class AlibabaCloud extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'alibaba_cloud.oss';
    }

    public static function sts(): StsClient
    {
        return app('alibaba_cloud.sts');
    }
}
