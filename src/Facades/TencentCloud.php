<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;
use Papaedu\Extension\TencentCloud\Cos\CosClient;
use Papaedu\Extension\TencentCloud\Tim\TimClient;
use Papaedu\Extension\TencentCloud\Tiw\TiwClient;
use Papaedu\Extension\TencentCloud\Trtc\TrtcClient;
use Papaedu\Extension\TencentCloud\Vod\VodClient;

class TencentCloud extends Facade
{
    public static function cos(string $name = ''): CosClient
    {
        return $name ? app('tencent_cloud.cos.'.$name) : app('tencent_cloud.cos');
    }

    public static function tim(string $name = ''): TimClient
    {
        return $name ? app('tencent_cloud.tim.'.$name) : app('tencent_cloud.tim');
    }

    public static function tiw(string $name = ''): TiwClient
    {
        return $name ? app('tencent_cloud.tiw.'.$name) : app('tencent_cloud.tiw');
    }

    public static function trtc(string $name = ''): TrtcClient
    {
        return $name ? app('tencent_cloud.trtc.'.$name) : app('tencent_cloud.trtc');
    }

    public static function vod(string $name = ''): VodClient
    {
        return $name ? app('tencent_cloud.vod.'.$name) : app('tencent_cloud.vod');
    }
}
