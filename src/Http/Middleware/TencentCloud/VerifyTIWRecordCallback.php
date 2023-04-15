<?php

namespace Papaedu\Extension\Http\Middleware\TencentCloud;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\Facades\TencentCloud;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyTIWRecordCallback
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
        if (TencentCloud::tiw()->checkRecordSign($request->input('ExpireTime'), $request->input('Sign'))) {
            return $next($request);
        }

        Log::warning('TIW 实时录制回调签名错误');
        throw new HttpException(500, 'Internal Server Error');
    }
}
