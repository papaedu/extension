<?php

namespace Papaedu\Extension\AlibabaCloud\Kernel;

use AlibabaCloud\Client\AlibabaCloud;

abstract class AlibabaCloudClient
{
    protected array $config;

    /**
     * @param  array  $config
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        AlibabaCloud::accessKeyClient($this->config['access_key_id'], $this->config['access_key_secret'])
            ->regionId($this->config['region_id'])
            ->asDefaultClient();
    }
}
