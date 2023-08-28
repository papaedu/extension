<?php

namespace Papaedu\Extension\Filesystem\Tencent;

use Papaedu\Extension\Facades\TencentCloud;
use Qcloud\Cos\Client as TencentCosClient;

class CdnAdapter extends TencentAdapterAbstract
{
    public function getClient(): TencentCosClient
    {
        if (! isset($this->client)) {
            $this->client = TencentCloud::cos('cdn')->getClient();
        }

        return $this->client;
    }
}
