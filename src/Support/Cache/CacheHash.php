<?php

namespace Papaedu\Extension\Support\Cache;

use Illuminate\Support\Facades\Redis;
use Papaedu\Extension\Exceptions\EmptyCacheException;

class CacheHash extends CacheTypeAbstract
{
    protected mixed $emptyCacheData = ['id' => 0];

    protected function getFromCache(string $cacheKey): array
    {
        return Redis::hgetall($cacheKey);
    }

    /**
     * @throws \Papaedu\Extension\Exceptions\EmptyCacheException
     */
    public function set(string $cacheKey, $data): void
    {
        if (empty($data)) {
            Redis::pipeline(function ($pipeline) use ($cacheKey) {
                $pipeline->hmset($cacheKey, $this->emptyCacheData);
                $pipeline->expire($cacheKey, $this->cacheEmptyExpire);
            });

            throw new EmptyCacheException();
        }

        if ($this->cacheExpire > 0) {
            Redis::pipeline(function ($pipeline) use ($cacheKey, $data) {
                $pipeline->hmset($cacheKey, $data);
                $pipeline->expire($cacheKey, $this->cacheExpire);
            });
        } else {
            Redis::hmset($cacheKey, $data);
        }
    }
}
