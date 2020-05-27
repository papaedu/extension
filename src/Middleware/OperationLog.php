<?php

namespace Papaedu\Extension\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Facades\Agent;
use Papaedu\Extension\Traits\PapaeduTrait;

class OperationLog
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
        if (app()->environment('production')) {
            $user = $this->authUser;
            $method = $request->method();
            $uri = $request->path();
            $queryString = http_build_query($request->except(['password', 'sn', 'token']));
            $userAgent = Agent::getUserAgent();
            $ip = $request->ip();

            $message = [
                implode(' ', [$user->id ?? '0', $user->username ?? 'nologin']),
                "{$method} {$uri} {$queryString}",
                $userAgent,
                $ip,
            ];

            Log::channel('oplog')->info(implode(' | ', $message));
        }

        return $next($request);
    }
}
