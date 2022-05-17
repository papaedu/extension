<?php

namespace Papaedu\Extension\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\Traits\Headers;

class ResponseLog
{
    use Headers;

    private const QUERY_EXCEPT = ['password', 'new_password', 'sn', 'token'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        $message = $this->getMessage($request, $response);

        Log::channel(config('extension.log.response.channel_name', 'resplog'))->info($this->formatMessage($message));

        return $response;
    }

    /**
     * Format log message.
     *
     * @param  array  $message
     * @return string
     */
    protected function formatMessage(array $message): string
    {
        return implode(' | ', $message);
    }

    /**
     * Get message of request and response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $response
     * @return array
     */
    protected function getMessage(Request $request, $response): array
    {
        $message = [
            $this->getUser(),
            $this->getQueryString($request),
            $this->getHeadersString($request),
            $request->userAgent(),
            $this->getIpPortString($request),
        ];

        if ($request->method() != 'GET' && $response instanceof JsonResponse) {
            $message[] = $response->isServerError() ? 'ServerError' : $response->getContent();
        } else {
            $message[] = '{}';
        }

        return $message;
    }

    protected function getUser(): string
    {
        if (! Auth::check()) {
            return 'nologin';
        }

        return sprintf('[%d]%s', Auth::id(), Auth::user()->username);
    }

    protected function getQueryString(Request $request): string
    {
        return implode(' ', [
            $request->method(),
            $request->path(),
            urldecode(http_build_query($request->except(self::QUERY_EXCEPT))),
        ]);
    }

    protected function getHeadersString(Request $request): string
    {
        return urldecode(http_build_query($this->getHeaders($request, config('extension.header.keys', []))));
    }

    protected function getIpPortString(Request $request): string
    {
        return "{$request->getClientIp()}:{$request->getPort()}";
    }
}
