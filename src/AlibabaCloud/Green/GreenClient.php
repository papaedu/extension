<?php

namespace Papaedu\Extension\AlibabaCloud\Green;

use Papaedu\Extension\AlibabaCloud\Kernel\AlibabaCloudClient;

class GreenClient extends AlibabaCloudClient
{
    public function image(): GreenImageClient
    {
        return new GreenImageClient($this->config);
    }

    public function text(): GreenTextClient
    {
        return new GreenTextClient($this->config);
    }
}
