<?php

namespace Papaedu\Extension\TencentCloud\Exceptions;

use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpException
 *
 * @package Papaedu\Extension\TencentCloud\Exceptions
 */
class HttpException extends TencentCloudException
{
    /**
     * @var \Psr\Http\Message\ResponseInterface|null
     */
    public $response;

    /**
     * HttpException constructor.
     *
     * @param string                                   $message
     * @param \Psr\Http\Message\ResponseInterface|null $response
     * @param int|null                                 $code
     */
    public function __construct($message, ResponseInterface $response = null, $code = null)
    {
        parent::__construct($message, $code);

        $this->response = $response;

        if ($response) {
            $response->getBody()->rewind();
        }
    }
}
