<?php

namespace Papaedu\Extension\Exceptions;

use Psr\Http\Message\ResponseInterface;

class InvalidGatewayException extends Exception
{
    /**
     * HttpException constructor.
     *
     * @param  string  $message
     * @param  mixed $content
     */
    public function __construct($message, $content ='')
    {

    }
}
