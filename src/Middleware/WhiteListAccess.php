<?php

namespace Papaedu\Extension\Middleware;

use Closure;
use Illuminate\Http\Request;
use Papaedu\Extension\Traits\PapaeduTrait;

class WhiteListAccess
{
    use PapaeduTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->ip(), config('whitelist.ip'))) {
            return $next($request);
        }

        $this->response->errorNotFound();
    }
}
