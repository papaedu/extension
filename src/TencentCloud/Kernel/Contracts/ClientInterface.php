<?php

namespace Papaedu\Extension\TencentCloud\Kernel\Contracts;

use Papaedu\Extension\TencentCloud\Kernel\HttpClient\HttpClient;

/**
 * Interface ClientInterface
 *
 * @package Papaedu\Extension\TencentCloud\Kernel\Contracts
 */
interface ClientInterface
{
    public function getClient(): HttpClient;
}
