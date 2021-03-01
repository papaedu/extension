<?php

namespace Papaedu\Extension\TencentCloud\Kernel\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

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
}