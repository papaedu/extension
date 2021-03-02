<?php

namespace Papaedu\Extension\TencentCloud\Kernel;

use Papaedu\Extension\TencentCloud\Kernel\Contracts\RequestInterface;

/**
 * Class Request
 *
 * @package Papaedu\Extension\TencentCloud\Kernel
 */
abstract class Request implements RequestInterface
{
    /**
     * @var array
     */
    protected array $parameters = [];

    /**
     * @param  bool  $filter
     * @return array
     */
    public function getParameters($filter = true): array
    {
        return (true === $filter && $this->parameters) ? array_filter($this->parameters) : $this->parameters;
    }

    /**
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    protected function getParameter(string $key, $default = null)
    {
        return array_key_exists($key, $this->parameters) ? $this->parameters[$key] : $default;
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
     */
    public function setParameter(string $key, $value)
    {
        $this->parameters[$key] = $value;
    }
}
