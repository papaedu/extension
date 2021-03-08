<?php

namespace Papaedu\Extension\TencentCloud\Kernel\Contracts;

interface ParameterInterface
{
    /**
     * @param  bool  $filter
     * @return array
     */
    public function getParameters($filter = true): array;

    /**
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setParameter(string $key, $value);
}
