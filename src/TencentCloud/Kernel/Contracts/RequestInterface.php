<?php

namespace Papaedu\Extension\TencentCloud\Kernel\Contracts;

/**
 * Interface RequestInterface
 *
 * @package Papaedu\Extension\TencentCloud\Kernel\Contracts
 */
interface RequestInterface
{
    /**
     * @return string
     */
    public function getUri(): string;

    /**
     * @return string
     */
    public function getAction(): string;

    /**
     * @return string
     */
    public function getRegion(): string;

    /**
     * @return string
     */
    public function getVersion(): string;
}
