<?php

namespace Extension\QCloud\Tiw;

use BiuBiuJun\QCloud\QCloud;

class TiwClient
{
    /**
     * @var \BiuBiuJun\QCloud\Tiw\TiwClient
     */
    protected $client;

    public function __construct()
    {
        $qCloud = new QCloud();
        $this->client = $qCloud->tiw(
            config('qcloud.tiw.secret_id'),
            config('qcloud.tiw.secret_key'),
            config('qcloud.tim.sdk_app_id')
        );
        $this->client->setSignForHmac(config('qcloud.tim.key'));
    }
}
