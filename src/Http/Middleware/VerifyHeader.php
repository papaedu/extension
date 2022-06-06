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
            throw new HttpException(403, 'Forbidden');
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
     * @return array
     */
    protected function getParams(Request $request): array
    {
        $params = $this->getHeaders($request, $this->headerKeys);
        $params = array_filter($params);

        if (! $params) {
            throw new HttpException(403, 'Forbidden');
        }
        if (isset($params[Header::TIMESTAMP->value]) && now()->diffInSeconds(Carbon::createFromTimestamp($params[Header::TIMESTAMP->value])) > self::TIMESTAMP_OFFSET_SECONDS) {
            throw new HttpException(403, 'Forbidden');
        }
        if (in_array(platform(), [Platform::MINI_PROGRAM, Platform::H5])) {
            unset($params[Header::USER_AGENT->value]);
        }

        $params['path'] = $request->path();
        $params += $request->all();
        $params = array_filter($params);

        return Arr::sortRecursive($params);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function validate(Request $request): bool
    {
        $params = $this->getParams($request);
        $sign = $request->header(Header::SIGN->value, '');

        if (! $params || ! $sign) {
            return false;
        }

        return md5(http_build_query($params).config('extension.header.secret')) == $sign;
    }
}
