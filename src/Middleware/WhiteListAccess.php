<?php

namespace Papaedu\Extension\Middleware;

use Closure;
use Illuminate\Http\Request;
use Papaedu\Extension\Traits\ExtensionTrait;

class WhiteListAccess
{
    use ExtensionTrait;

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

        $this->response->errorNotFound();
    }
}
