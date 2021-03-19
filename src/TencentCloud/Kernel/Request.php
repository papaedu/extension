<?php

namespace Papaedu\Extension\TencentCloud\Kernel;

use Papaedu\Extension\TencentCloud\Kernel\Contracts\ParameterInterface;
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
     * @return array
     */
    public function getParameters(): array
    {
        if (!$this->parameters) {
            return [];
        }

        return $this->parameters;
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
        if ($value instanceof ParameterInterface) {
            $this->parameters[$key] = $value->getParameters();
        } else {
            $this->parameters[$key] = $value;
        }
    }
}
