<?php

namespace Papaedu\Extension\Models\Methods;

use Illuminate\Support\Facades\Redis;

trait SocialiteMethod
{
    /**
     * 设置临时缓存，用于后续绑定账号使用
     *
     * @param  string  $driver  驱动名称:wechat
     * @param  int  $type  授权类型
     * @param  string  $openid
     * @param  array  $data
     * @return void
     */
    public static function setTemp(string $driver, int $type, string $openid, array $data): void
    {
        $key = sprintf(self::TEMP_KEY, $driver, $openid);
        Redis::hmset($key, $data + ['type' => $type]);
        Redis::expire($key, self::TEMP_EXPIRE_SECONDS);
    }

    public static function getTemp(string $driver, string $openid): array
    {
        return Redis::hgetall(sprintf(self::TEMP_KEY, $driver, $openid));
    }

    public static function deleteTemp(string $driver, string $openid): void
    {
        Redis::del(sprintf(self::TEMP_KEY, $driver, $openid));
    }
}
