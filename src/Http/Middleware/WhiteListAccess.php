<?php

namespace Papaedu\Extension\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use IPTools\IP;
use IPTools\Range;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WhiteListAccess
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
        if (false === config('extension.whitelist.enable') || $this->withInList($request->ip())) {
            return $next($request);
        }

        throw new HttpException(404, 'Not Found');
    }

    /**
     * @param  string|null  $targetIp
     * @return bool
     */
    protected function withInList(?string $targetIp): bool
    {
        if (is_null($targetIp)) {
            return false;
        }

        try {
            $targetIp = new IP($targetIp);
            $ips = explode(',', config('extension.whitelist.ip'));
            foreach ($ips as $ip) {
                if (Range::parse($ip)->contains($targetIp)) {
                    return true;
                }
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
