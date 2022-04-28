<?php

namespace Papaedu\Extension\TencentCloud\Kernel\Contracts;

interface RequestInterface
{
    /**
     * @return string
     */
    public function getUri(): string;

    /**
     * @return array
     */
    public function getParameters(): array;

    /**
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setParameter(string $key, $value);
}
