<?php

namespace Papaedu\Extension\Traits;

use ErrorException;
use Illuminate\Support\Facades\Auth;
use Papaedu\Extension\Support\Logger;
use Papaedu\Extension\Support\Response;

/**
 * @property \Papaedu\Extension\Support\Response $response
 * @property \Modules\Admin\Entities\Admin|\Modules\Teacher\Entities\Teacher|\Modules\User\Entities\User $authUser
 */
trait PapaeduTrait
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

    /**
     * Get the authenticated user.
     *
     * @return \Modules\Admin\Entities\Admin|\Modules\Teacher\Entities\Teacher|\Modules\User\Entities\User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected function authUser()
    {
        return Auth::guard('sanctum')->user();
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function authCheck()
    {
        return Auth::guard('sanctum')->check();
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
            'response', 'authUser', 'logger',
        ];

        if (in_array($key, $callable) && method_exists($this, $key)) {
            return $this->$key();
        }

        throw new ErrorException('Undefined property ' . get_class($this) . '::' . $key);
    }
}
