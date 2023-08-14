<?php

namespace Papaedu\Extension\Filesystem\Tencent;

use Papaedu\Extension\Facades\TencentCloud;
use Qcloud\Cos\Client as TencentCosClient;

class FileAdapter extends TencentAdapterAbstract
{
    public function getClient(): TencentCosClient
    {
        if (! isset($this->client)) {
            $this->client = TencentCloud::cos('file')->getClient();
        }

        return $this->client;
    }
}
