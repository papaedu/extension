<?php

namespace Papaedu\Extension\Facades;

use Illuminate\Support\Facades\Facade;
use Papaedu\Extension\TencentCloud\Tim\TimClient;
use Papaedu\Extension\TencentCloud\Tiw\TiwClient;
use Papaedu\Extension\TencentCloud\Trtc\TrtcClient;
use Papaedu\Extension\TencentCloud\Vod\VodClient;

class TencentCloud extends Facade
{
    /**
     * @return \Papaedu\Extension\TencentCloud\Tim\TimClient
     */
    public static function tim(): TimClient
    {
        return app('tencent_cloud.tim');
    }

    /**
     * @return \Papaedu\Extension\TencentCloud\Vod\VodClient
     */
    public static function vod(): VodClient
    {
        return app('tencent_cloud.vod');
    }

    /**
     * @return \Papaedu\Extension\TencentCloud\Tiw\TiwClient
     */
    public static function tiw(): TiwClient
    {
        return app('tencent_cloud.tiw');
    }

    /**
     * @return \Papaedu\Extension\TencentCloud\Trtc\TrtcClient
     */
    public static function trtc(): TrtcClient
    {
        return app('tencent_cloud.trtc');
    }
}
