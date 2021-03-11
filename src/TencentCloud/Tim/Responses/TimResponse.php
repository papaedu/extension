<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses;

use Papaedu\Extension\TencentCloud\Exceptions\BadRequestException;
use Papaedu\Extension\TencentCloud\Exceptions\HttpException;
use Papaedu\Extension\TencentCloud\Kernel\Response;
use Psr\Http\Message\ResponseInterface;

abstract class TimResponse extends Response
{
    /**
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\BadRequestException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\HttpException
     */
    public function handle(ResponseInterface $response)
    {
        if ($response->getStatusCode() != 200) {
            throw new HttpException(
                'Request failed:'.$response->getBody()->getContents(),
                $response->getBody()->rewind(),
                $response->getStatusCode()
            );
        }

        $content = json_decode($response->getBody()->getContents(), true);
        $this->content = $content;
        if (isset($content['ActionStatus']) && 'OK' == $content['ActionStatus']) {
            $this->isSuccessful = true;
        } else {
            $this->isSuccessful = false;
            if (isset($content['ActionStatus']) && 'FAIL' == $content['ActionStatus']) {
                throw new BadRequestException($content['ErrorInfo'], $content['ErrorCode']);
            }
        }
    }

    /**
     * @return string
     */
    public function getActionStatus(): string
    {
        return $this->content['ActionStatus'];
    }

    /**
     * @return string
     */
    public function getErrorInfo(): string
    {
        return $this->content['ErrorInfo'];
    }

    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->content['ErrorCode'];
    }
}
