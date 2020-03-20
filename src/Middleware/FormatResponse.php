<?php

namespace Papaedu\Extension\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormatResponse
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
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $data = $response->getData();

            $result['data'] = $data->data ?? [];

            if ($data->meta ?? '') {
                $result['meta'] = [
                    'current_page' => $data->meta->current_page,
                    'last_page' => $data->meta->last_page,
                    'total' => $data->meta->total,
                ];
            }

            $response = $response->setData($result);
        }

        return $response;
    }
}
