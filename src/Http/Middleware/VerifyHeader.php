<?php

namespace Papaedu\Extension\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use Papaedu\Extension\Enums\Header;
use Papaedu\Extension\Enums\Platform;
use Papaedu\Extension\Traits\Headers;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyHeader
{
    use Headers;

    /**
     * @var array
     */
    protected array $headerKeys = [];

    private const TIMESTAMP_OFFSET_SECONDS = 60;

    public function __construct()
    {
        $this->headerKeys = config('extension.header.keys', []);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (! $this->headerKeys) {
            return $next($request);
        }

        if ($response = $this->beforeValidate($request, $next)) {
            return $response;
        }

        if (false === $this->validate($request)) {
            throw new HttpException(403, 'Forbidden', code: 10001);
        }

        if (Redis::sismember(config('extension.device.ban_list'), $request->header(Header::DEVICE_ID->value))) {
            throw new HttpException(400, trans('extension::auth.device_baned'));
        }

        if ($response = $this->validated($request, $next)) {
            return $response;
        }

        return $next($request);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function beforeValidate(Request $request, Closure $next)
    {
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function validated(Request $request, Closure $next)
    {
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function validate(Request $request): bool
    {
        $payload = $this->getPayload($request);
        $sign = $request->header(Header::SIGN->value, '');

        if (! $payload || ! $sign) {
            return false;
        }

        return md5(Arr::query($payload).config('extension.header.secret')) == $sign;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getPayload(Request $request): array
    {
        $payload = $this->getHeaders($request, $this->headerKeys);

        if (! $payload) {
            throw new HttpException(403, 'Forbidden', code: 10002);
        }
        if (isset($payload[Header::TIMESTAMP->value]) && now()->diffInSeconds(Carbon::createFromTimestamp($payload[Header::TIMESTAMP->value])) > self::TIMESTAMP_OFFSET_SECONDS) {
            throw new HttpException(403, 'Forbidden', code: 10003);
        }
        if (in_array(platform(), [Platform::MINI_PROGRAM, Platform::H5])) {
            unset($payload[Header::USER_AGENT->value]);
        }

        $payload['path'] = $request->path();
        $payload += $request->all();

        return Arr::sortRecursive($payload);
    }
}
