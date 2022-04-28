<?php

namespace Papaedu\Extension\TencentCloud\Kernel;

use GuzzleHttp\Promise\PromiseInterface;
use Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException;
use Papaedu\Extension\TencentCloud\Kernel\Contracts\ClientInterface;
use Papaedu\Extension\TencentCloud\Kernel\Contracts\RequestInterface;
use Papaedu\Extension\TencentCloud\Kernel\Contracts\ResponseInterface;

abstract class Client implements ClientInterface
{
    /**
     * @param  \Papaedu\Extension\TencentCloud\Kernel\Contracts\RequestInterface  $request
     * @param  array  $options
     * @return \Papaedu\Extension\TencentCloud\Kernel\Contracts\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\BadRequestException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\HttpException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException
     */
    public function sendRequest(RequestInterface $request, array $options = []): ResponseInterface
    {
        $responseApplication = str_replace('Request', 'Response', get_class($request));
        if (!class_exists($responseApplication)) {
            throw new InvalidArgumentException("Response Class {$responseApplication} not exist.");
        }

        $response = new $responseApplication();

        return $this->getClient()->request($request, $response, $options);
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Kernel\Contracts\RequestInterface  $request
     * @param  array  $options
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function sendRequestAsync(RequestInterface $request, array $options = []): PromiseInterface
    {
        return $this->getClient()->requestAsync($request, $options);
    }
}
