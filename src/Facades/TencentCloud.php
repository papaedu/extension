<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;
use Papaedu\Extension\TencentCloud\Tim\TimClient;

class TencentCloud extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'tencent_cloud.tim';
    }

    /**
     * @param  string  $name
     * @return \Papaedu\Extension\TencentCloud\Tim\TimClient
     */
    public static function tim(string $name = ''): TimClient
    {
        return $name ? app('tencent_cloud.tim.'.$name) : app('tencent_cloud.tim');
    }
}
