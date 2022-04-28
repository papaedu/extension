<?php

namespace Papaedu\Extension\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @deprecated
 */
class FormatResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $data = $response->getData(true);

            if (isset($data['meta'])) {
                $meta = [
                    'current_page' => $data['meta']['current_page'],
                    'last_page' => $data['meta']['last_page'],
                    'total' => $data['meta']['total'],
                ];
                $data['meta'] = $meta;
            }
            if (isset($data['links'])) {
                unset($data['links']);
            }
            $response = $response->setData($data);
        }

        return $response;
    }
}
