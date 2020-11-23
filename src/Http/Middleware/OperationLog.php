<?php

namespace Papaedu\Extension\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Facades\Agent;

class OperationLog
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
        if (Auth::check()) {
            $authUser = Auth::user();
            $username = $authUser->username ?? $authUser->mobile;
            $user = "[{$authUser->id}]{$username}";
        } else {
            $user = 'nologin';
        }

        $method = $request->method();
        $uri = $request->path();
        $queryString = urldecode(http_build_query($request->except(['password', 'sn', 'token'])));
        $userAgent = Agent::getUserAgent();
        $ip = $request->getClientIp();
        $port = $request->getPort();

        $message = [
            $user,
            "{$method} {$uri} {$queryString}",
            $userAgent,
            "{$ip}:{$port}",
        ];

        Log::channel('oplog')->info(implode(' | ', $message));

        return $next($request);
    }
}
