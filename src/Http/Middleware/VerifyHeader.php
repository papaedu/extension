<?php

namespace Papaedu\Extension\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        $headerKeys = config('extension.header.keys', []);
        if (!$headerKeys) {
            return $next($request);
        }

        $headers = [];
        foreach ($headerKeys as $headerKey) {
            $headers[$headerKey] = $request->header($headerKey);
        }
        if (!$headers) {
            throw new HttpException(403, 'Forbidden');
        }

        ksort($headers);
        $string = http_build_query($headers);
        if (md5($string.config('extension.header.secret')) == $request->header('sign')) {
            return $next($request);
        }

        throw new HttpException(403, 'Forbidden');
    }
}
