<?php

namespace Papaedu\Extension\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Facades\Agent;
use Papaedu\Extension\Traits\PapaeduHelpers;

class OperationLog
{
    use PapaeduHelpers;

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
            $monolog = Log::getMonolog();
            $logHandler = $monolog->popHandler();
            Log::useDailyFiles(storage_path('logs/operation.log'), 180, 'debug');

            $user = $this->authUser;
            $method = $request->method();
            $uri = $request->path();
            $queryString = http_build_query($request->except(['password', 'sn', 'token']));
            $userAgent = Agent::getUserAgent();
            $ip = $request->ip();

            $message = [
                join([$user->id, $user->username], ' '),
                "{$method} {$uri} {$queryString}",
                $userAgent,
                $ip,
            ];

            Log::info(join($message, ' | '));

            $monolog->popHandler();
            $monolog->pushHandler($logHandler);
        }

        return $next($request);
    }
}
