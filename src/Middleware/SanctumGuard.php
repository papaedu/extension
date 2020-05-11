<?php

namespace Papaedu\Extension\Middleware;

use Closure;
use Papaedu\Extension\Traits\PapaeduHelpers;

class SanctumGuard
{
    use PapaeduHelpers;

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
            $guard = config('auth.defaults.guard');
            $provider = config("auth.guards.{$guard}.provider");
        }

        $model = config("auth.providers.{$provider}.model");
        if (!$request->user() instanceof $model) {
            $this->response->errorUnauthorized();
        }

        return $next($request);
    }
}
