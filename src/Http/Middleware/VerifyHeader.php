<?php

namespace Papaedu\Extension\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyHeader
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
        $headers = Arr::only($request->header(), config('extension.header.keys', []));
        if (!$headers) {
            return $next($request);
        }

        ksort($headers);
        $string = http_build_query($headers);
        if (md5($string.config('extension.header.secret')) == $request->header('sign')) {
            return $next($request);
        }

        throw new HttpException(403, 'Forbidden');
    }
}
