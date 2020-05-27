<?php

namespace Papaedu\Extension\Middleware;

use Closure;
use Papaedu\Extension\Traits\PapaeduTrait;

class SanctumGuard
{
    use PapaeduTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $provider
     * @return mixed
     */
    public function handle($request, Closure $next, $provider = '')
    {
        if (!$provider) {
            $provider = config('auth.defaults.sanctum');
        }

        $model = config("auth.providers.{$provider}.model");
        if (!$request->user() instanceof $model) {
            $this->response->errorUnauthorized();
        }

        return $next($request);
    }
}
