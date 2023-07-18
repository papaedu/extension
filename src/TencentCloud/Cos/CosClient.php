<?php

namespace Papaedu\Extension\TencentCloud\Cos;

use Papaedu\Extension\TencentCloud\Kernel\QCloudClient;
use Qcloud\Cos\Client as TencentCosClient;

class CosClient extends QCloudClient
{
    protected TencentCosClient $client;

    protected function initClient(): void
    {
        $this->client = new TencentCosClient([
            'region' => $this->config['region'],
            'schema' => 'https',
            'signHost' => true,
            'domain' => $this->config['domain'],
            'credentials' => [
                'secretId' => $this->config['secret_id'],
                'secretKey' => $this->config['secret_key'],
            ],
        ]);
    }

    public function getClient(): TencentCosClient
    {
        return $this->client;
    }
}
