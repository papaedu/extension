<?php

namespace Papaedu\Extension\Http\Middleware\TencentCloud;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\Facades\TencentCloud;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyTrtcRecordCallback
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
        if (TencentCloud::trtc()->checkRecordSign($request->getContent(), $request->header('sign'))) {
            return $next($request);
        }

        Log::warning('TRTC record callback sign error.');
        throw new HttpException(500, 'Internal Server Error');
    }
}
