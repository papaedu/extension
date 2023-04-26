<?php

namespace Papaedu\Extension\Support;

use Illuminate\Support\Facades\Redis;
use Papaedu\Extension\Exceptions\EmptyCacheException;

class CacheString extends CacheTypeAbstract
{
    protected mixed $emptyCacheData = '{}';

    protected function getFromCache(string $cacheKey): ?string
    {
        return Redis::get($cacheKey);
    }

    /**
     * @throws \Papaedu\Extension\Exceptions\EmptyCacheException
     */
    public function set(string $cacheKey, $data): void
    {
        if (empty($data)) {
            Redis::set($cacheKey, $this->emptyCacheData, 'EX', $this->cacheEmptyExpire, 'NX');

            throw new EmptyCacheException();
        }

        if ($this->cacheExpire > 0) {
            Redis::set($cacheKey, $data, 'EX', $this->cacheExpire, 'NX');
        } else {
            Redis::setnx($cacheKey, $data);
        }
    }
}
