<?php

namespace Papaedu\Extension\TencentCloud\Kernel\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Papaedu\Extension\TencentCloud\Kernel\Contracts\RequestInterface;
use Papaedu\Extension\TencentCloud\Kernel\Contracts\ResponseInterface;

abstract class HttpClient
{
    const MAX_RETRIES = 3;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected ClientInterface $httpClient;

    /**
     * @var string
     */
    protected string $baseUri;

    public function getHttpClient(): ClientInterface
    {
        if (!$this->httpClient instanceof ClientInterface) {
            $handlerStack = HandlerStack::create(new CurlHandler());
            $handlerStack->push($this->retryMiddleware(), 'retry');

            $this->httpClient = new Client([
                'base_uri' => $this->baseUri,
                'handler' => $handlerStack,
            ]);
        }

        return $this->httpClient;
    }

    /**
     * @return \Closure
     */
    protected function retryMiddleware(): \Closure
    {
        return Middleware::retry(
            function (
                $retries,
                RequestInterface $request,
                Response $response = null
            ) {
                if ($retries >= self::MAX_RETRIES) {
                    return false;
                }

                if ($response && $body = $response->getBody()) {
                    // Retry on server errors
                    $response = json_decode($body, true);

                    // TODO:
//                    if (!empty($response['errcode'])) {
//                        $this->app['logger']->debug('Retrying with refreshed access token.');
//
//                        return true;
//                    }
                }

                return false;
            },
            function () {
                return 500;
            }
        );
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Kernel\Contracts\RequestInterface  $request
     * @param  \Papaedu\Extension\TencentCloud\Kernel\Contracts\ResponseInterface  $response
     * @param  array  $options
     * @return \Papaedu\Extension\TencentCloud\Kernel\Contracts\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\HttpException
     */
    public function request(
        RequestInterface $request,
        ResponseInterface $response,
        array $options = []
    ): ResponseInterface {
        $resp = $this->getHttpClient()->request('POST', $request->getUri(), $this->options($request, $options));
        $response->handle($resp);

        return $response;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Kernel\Contracts\RequestInterface  $request
     * @param  array  $options
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function requestAsync(RequestInterface $request, array $options = []): PromiseInterface
    {
        return $this->getHttpClient()->requestAsync('POST', $request->getUri(), $this->options($request, $options));
    }
}
