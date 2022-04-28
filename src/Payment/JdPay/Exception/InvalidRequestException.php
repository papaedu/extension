<?php

namespace Papaedu\Extension\Payment\JdPay\Exception;

use Exception;

/**
 * Invalid Request Exception
 *
 * Thrown when a request is invalid or missing required fields.
 */
class InvalidRequestException extends Exception implements JdPayException
{
}
