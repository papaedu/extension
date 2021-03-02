<?php

namespace Papaedu\Extension\TencentCloud\Kernel;

/**
 * Class Parameter
 *
 * @package Papaedu\Extension\TencentCloud\Kernel
 */
abstract class Parameter
{
    protected array $parameters = [];

    /**
     * @param  bool  $filter
     * @return array
     */
    public function getParameters($filter = true): array
    {
        if (!$this->parameters) {
            return [];
        }

        if (true === $filter) {
            return array_filter($this->parameters);
        }

        return $this->parameters;
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
