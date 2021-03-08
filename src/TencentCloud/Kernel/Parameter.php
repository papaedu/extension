<?php

namespace Papaedu\Extension\TencentCloud\Kernel;

use Papaedu\Extension\TencentCloud\Kernel\Contracts\ParameterInterface;

/**
 * Class Parameter
 *
 * @package Papaedu\Extension\TencentCloud\Kernel
 */
abstract class Parameter implements ParameterInterface
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
        if ($value instanceof ParameterInterface) {
            $this->parameters[$key] = $value->getParameters();
        } else {
            $this->parameters[$key] = $value;
        }
    }
}
