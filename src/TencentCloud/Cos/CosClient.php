<?php

namespace Papaedu\Extension\TencentCloud\Cos;

use Papaedu\Extension\TencentCloud\Kernel\QCloudClient;
use Qcloud\Cos\Client as TencentCosClient;

/**
 * @method \Qcloud\Cos\Client getClient()
 */
class CosClient extends QCloudClient
{
    protected function initClient(): void
    {
        $this->client = new TencentCosClient([
            'region' => $this->config['region'],
            'schema' => 'https',
            'signHost' => true,
            'credentials' => [
                'secretId' => $this->config['secret_id'],
                'secretKey' => $this->config['secret_key'],
            ],
        ]);
    }
}
