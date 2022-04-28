<?php

namespace Papaedu\Extension\TencentCloud\Kernel\Contracts;

use Papaedu\Extension\TencentCloud\Kernel\HttpClient\HttpClient;

interface ClientInterface
{
    public function getClient(): HttpClient;
}
