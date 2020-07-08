<?php

namespace Papaedu\Extension\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class SanctumGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $provider
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function handle($request, Closure $next, $provider = '')
    {
        if (!$provider) {
            $provider = config('auth.defaults.sanctum');
        }

        $model = config("auth.providers.{$provider}.model");
        if (!$request->user() instanceof $model) {
            throw new AuthorizationException('Unauthorized');
        }

        return $next($request);
    }
}
