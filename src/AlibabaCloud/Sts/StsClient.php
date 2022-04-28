<?php

namespace Papaedu\Extension\AlibabaCloud\Sts;

use Papaedu\Extension\AlibabaCloud\Kernel\AlibabaCloudClient;

class StsClient extends AlibabaCloudClient
{
    public function oss(): StsOssClient
    {
        return new StsOssClient($this->config);
    }
}
