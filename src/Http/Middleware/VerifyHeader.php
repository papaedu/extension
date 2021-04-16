<?php

namespace Papaedu\Extension\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyHeader
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
        $headerKeys = config('extension.header.keys', []);
        if (!$headerKeys) {
            return $next($request);
        }

        $headers = $this->getHeaders($request, $headerKeys);

        if (false === $this->validate($headers, $request->header('sign', ''))) {
            throw new HttpException(403, 'Forbidden');
        }

        if (Redis::sismember(config('extension.device.ban_list'), $request->header('device-id'))) {
            throw new HttpException(400, trans('extension::auth.device_baned'));
        }

        return $next($request);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $headerKeys
     * @return array
     */
    protected function getHeaders(Request $request, array $headerKeys): array
    {
        $headers = [];
        foreach ($headerKeys as $headerKey) {
            $headers[$headerKey] = $request->header($headerKey);
        }
        $headers = array_filter($headers);

        if (!$headers) {
            throw new HttpException(403, 'Forbidden');
        }

        ksort($headers);

        return $headers;
    }

    /**
     * @param  array  $headers
     * @param  string  $sign
     * @return bool
     */
    protected function validate(array $headers, string $sign): bool
    {
        if (!$headers || !$sign) {
            return false;
        }

        switch (config('extension.header.verify_type')) {
            case 'MD5':
                $result = $this->validateByMd5($headers, $sign);
                break;
            case 'RSA':
                $result = $this->validateByRsa($headers, $sign);
                break;
            default:
                $result = false;
        }

        return $result;
    }

    /**
     * @param  array  $headers
     * @param  string  $sign
     * @return bool
     */
    protected function validateByMd5(array $headers, string $sign): bool
    {
        $encryptString = urldecode(http_build_query($headers)).config('extension.header.secret');

        return md5($encryptString) == $sign;
    }

    /**
     * @param  array  $headers
     * @param  string  $sign
     * @return bool
     */
    private function validateByRsa(array $headers, string $sign): bool
    {
        $encryptString = http_build_query($headers);

        return 1 == openssl_verify(
                $encryptString,
                base64_decode($sign),
                config('extension.header.public_key_path')
            );
    }
}
