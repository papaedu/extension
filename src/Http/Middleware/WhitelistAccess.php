<?php

namespace Papaedu\Extension\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Papaedu\Extension\Traits\ValidateIP;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WhitelistAccess
{
    use ValidateIP;

    public function __construct()
    {
        $this->ips = config('extension.whitelist.ips');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (false === config('extension.whitelist.enable') || $this->inIps($request->ip())) {
            return $next($request);
        }

        throw new HttpException(404, 'Not Found');
    }
}
