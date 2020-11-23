<?php

namespace Papaedu\Extension\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WhiteListAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!config('whitelist.enable') || in_array($request->ip(), config('whitelist.ip'))) {
            return $next($request);
        }

        throw new HttpException(404, 'Not Found');
    }
}
