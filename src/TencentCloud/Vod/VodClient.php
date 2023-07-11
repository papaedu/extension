<?php

namespace Papaedu\Extension\TencentCloud\Vod;

use Papaedu\Extension\TencentCloud\Kernel\TencentCloudClient;
use TencentCloud\Common\Credential;
use TencentCloud\Vod\V20180717\VodClient as TencentVodClient;

/**
 * @method \TencentCloud\Vod\V20180717\VodClient getClient()
 */
class VodClient extends TencentCloudClient
{
    protected function initClient(): void
    {
        $credential = new Credential($this->config['secret_id'], $this->config['secret_key']);
        $this->client = new TencentVodClient($credential, $this->config['region']);
    }
}
