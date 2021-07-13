<?php

namespace Papaedu\Extension\JdPay\Exception;

use Exception;

/**
 * Invalid Request Exception
 *
 * Thrown when a request is invalid or missing required fields.
 */
class InvalidRequestException extends Exception implements JdPayException
{
}
