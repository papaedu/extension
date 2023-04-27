<?php

namespace Papaedu\Extension\Support\Cache;

use Closure;

class CacheNoLock extends CacheAbstract
{
    /**
     * @throws \Papaedu\Extension\Exceptions\EmptyCacheException
     */
    protected function get(string $cacheKey, Closure $callback): mixed
    {
        $cache = $this->cacheType->get($cacheKey);
        if (! empty($cache)) {
            return $cache;
        }

        $data = $callback();
        $this->cacheType->set($cacheKey, $data);

        return $data;
    }

    /**
     * @param  string  $cacheKey
     * @param  \Closure  $callback
     * @return void
     * @throws \Papaedu\Extension\Exceptions\EmptyCacheException
     */
    protected function init(string $cacheKey, Closure $callback): void
    {
        if ($this->cacheType->exists($cacheKey)) {
            return;
        }

        $data = $callback();
        $this->cacheType->set($cacheKey, $data);
    }
}
