<?php

namespace Papaedu\Extension\Traits;

use ErrorException;
use Papaedu\Extension\Support\Logger;
use Papaedu\Extension\Support\Response;

/**
 * @property \Papaedu\Extension\Support\Response $response
 * @property \Papaedu\Extension\Support\Logger $logger
 */
trait ExtensionTrait
{
    /**
     * @var string
     */
    protected $loggerModule = '';

    /**
     * Get the response.
     *
     * @return \Papaedu\Extension\Support\Response
     */
    protected function response()
    {
        return app(Response::class);
    }

    protected function logger()
    {
        return app(Logger::class, ['module' => $this->loggerModule]);
    }

    /**
     * Magically handle calls to certain properties.
     *
     * @param  string  $key
     * @return mixed
     * @throws \ErrorException
     */
    public function __get(string $key)
    {
        $callable = [
            'response', 'logger',
        ];

        if (in_array($key, $callable) && method_exists($this, $key)) {
            return $this->$key();
        }

        throw new ErrorException('Undefined property '.get_class($this).'::'.$key);
    }
}
