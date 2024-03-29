<?php

namespace Papaedu\Extension\Http\Middleware\TencentCloud;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\Facades\TencentCloud;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyTIWTranscodeCallback
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
        if (TencentCloud::tiw()->checkTranscodeSign($request->input('ExpireTime'), $request->input('Sign'))) {
            return $next($request);
        }

        Log::warning('TIW 文档转码回调异常');
        throw new HttpException(500, 'Internal Server Error');
    }
}
