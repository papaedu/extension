<?php

namespace Papaedu\Extension\TencentCloud\Kernel;

use GuzzleHttp\Command\Guzzle\GuzzleClient;

abstract class QCloudClient
{
    protected GuzzleClient $client;

    public function __construct(protected array $config)
    {
        $this->initClient();
    }

    abstract protected function initClient(): void;

    public function getClient(): GuzzleClient
    {
        return $this->client;
    }
}
