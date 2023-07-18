<?php

namespace Papaedu\Extension\TencentCloud\Kernel;

abstract class QCloudClient
{
    public function __construct(protected array $config)
    {
        $this->initClient();
    }

    abstract protected function initClient(): void;
}
