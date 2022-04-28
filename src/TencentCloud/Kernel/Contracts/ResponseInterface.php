<?php

namespace Papaedu\Extension\TencentCloud\Kernel\Contracts;

use Psr\Http\Message\ResponseInterface as PrsResponseInterface;

interface ResponseInterface
{
    /**
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\BadRequestException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\HttpException
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
