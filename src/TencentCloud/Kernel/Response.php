<?php

namespace Papaedu\Extension\TencentCloud\Kernel;

use Papaedu\Extension\TencentCloud\Kernel\Contracts\ResponseInterface;

abstract class Response implements ResponseInterface
{
    /**
     * @var bool
     */
    protected bool $isSuccessful = false;

    /**
     * @var array
     */
    protected array $content = [];

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }
}
