<?php

namespace Papaedu\Extension\TencentCloud\Vod;

use Papaedu\Extension\TencentCloud\Kernel\TencentCloudClient;
use TencentCloud\Common\Credential;
use TencentCloud\Vod\V20180717\VodClient as TencentVodClient;

class VodClient extends TencentCloudClient
{
    protected function initClient()
    {
        $credential = new Credential($this->config['secret_id'], $this->config['secret_key']);
        $this->client = new TencentVodClient($credential, $this->config['region']);
    }
}
