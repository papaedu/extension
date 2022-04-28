<?php

namespace Papaedu\Extension\Exceptions;

use Psr\Http\Message\ResponseInterface;

class HttpException extends Exception
{
    public ?ResponseInterface $response;

    /**
     * HttpException constructor.
     *
     * @param  string  $message
     * @param  \Psr\Http\Message\ResponseInterface|null  $response
     * @param  int  $code
     */
    public function __construct(string $message, ResponseInterface $response = null, int $code = 0)
    {
        parent::__construct($message, $code);

        $response?->getBody()->rewind();
    }
}
