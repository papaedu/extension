<?php

namespace Papaedu\Extension\TencentCloud\Kernel;

use TencentCloud\Common\AbstractClient;

abstract class TencentCloudClient
{
    protected array $config;

    protected AbstractClient $client;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->initClient();
    }

    abstract protected function initClient();

    /**
     * @return \TencentCloud\Common\AbstractClient
     */
    public function getClient(): AbstractClient
    {
        return $this->client;
    }
}
