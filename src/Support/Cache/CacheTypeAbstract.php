<?php

namespace Papaedu\Extension\Support;

use Illuminate\Support\Facades\Redis;
use Papaedu\Extension\Exceptions\EmptyCacheException;

abstract class CacheTypeAbstract
{
    protected mixed $emptyCacheData;

    public function __construct(protected int $cacheExpire = 86400, protected int $cacheEmptyExpire = 600)
    {
    }

    abstract protected function getFromCache(string $cacheKey): mixed;

    /**
     * @throws \Papaedu\Extension\Exceptions\EmptyCacheException
     */
    public function get(string $cacheKey): string|array|null
    {
        $cache = $this->getFromCache($cacheKey);

        if (empty($cache)) {
            return null;
        }

        if ($cache == $this->emptyCacheData) {
            throw new EmptyCacheException();
        }

        if ($this->cacheExpire > 0) {
            Redis::expire($cacheKey, $this->cacheExpire);
        }

        return $cache;
    }

    /**
     * @throws \Papaedu\Extension\Exceptions\EmptyCacheException
     */
    abstract public function set(string $cacheKey, $data): void;

    public function exists(string $cacheKey): bool
    {
        if (! Redis::exists($cacheKey)) {
            return false;
        }

        if ($this->cacheExpire > 0) {
            Redis::expire($cacheKey, $this->cacheExpire);
        }

        return true;
    }
}
