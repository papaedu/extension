<?php

namespace Papaedu\Extension\TencentCloud\Kernel\Contracts;

use Psr\Http\Message\ResponseInterface as PrsResponseInterface;

/**
 * Interface ResponseInterface
 *
 * @package Papaedu\Extension\TencentCloud\Kernel\Contracts
 */
interface ResponseInterface
{
    /**
     * @param  \Psr\Http\Message\ResponseInterface  $response
     */
    public function handle(PrsResponseInterface $response);

    /**
     * @return bool
     */
    public function isSuccessful(): bool;

    /**
     * @return array
     */
    public function getContent(): array;
}
