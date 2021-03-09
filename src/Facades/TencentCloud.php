<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;

class TencentCloud extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tencent_cloud.tim';
    }

    /**
     * @param  string  $name
     * @return \Papaedu\Extension\TencentCloud\Tim\TimClient
     */
    public static function tim($name = '')
    {
        return $name ? app('tencent_cloud.tim.'.$name) : app('tencent_cloud.tim');
    }
}
