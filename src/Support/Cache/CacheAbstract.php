<?php

namespace Papaedu\Extension\Support\Cache;

use Closure;

abstract class CacheAbstract
{
    use CacheParameter;

    protected CacheTypeAbstract $cacheType;

    protected int $cacheExpire = 86400;

    protected int $cacheEmptyExpire = 600;

    /**
     * @throws \Papaedu\Extension\Exceptions\EmptyCacheException
     */
    public function getString(string $cacheKey, Closure $callback): ?string
    {
        $this->cacheType = new CacheString($this->cacheExpire, $this->cacheEmptyExpire);

        return $this->get($cacheKey, $callback);
    }

    public function initString(string $cacheKey, Closure $callback): void
    {
        $this->cacheType = new CacheString($this->cacheExpire, $this->cacheEmptyExpire);
        $this->init($cacheKey, $callback);
    }

    /**
     * @throws \Papaedu\Extension\Exceptions\EmptyCacheException
     */
    public function getHash(string $cacheKey, Closure $callback): ?array
    {
        $this->cacheType = new CacheHash($this->cacheExpire, $this->cacheEmptyExpire);

        return $this->get($cacheKey, $callback);
    }

    public function initHash(string $cacheKey, Closure $callback): void
    {
        $this->cacheType = new CacheHash($this->cacheExpire, $this->cacheEmptyExpire);
        $this->init($cacheKey, $callback);
    }

    /**
     * @throws \Papaedu\Extension\Exceptions\EmptyCacheException
     */
    public function getSet(string $cacheKey, Closure $callback): ?array
    {
        $this->cacheType = new CacheSet($this->cacheExpire, $this->cacheEmptyExpire);

        return $this->get($cacheKey, $callback);
    }

    public function initSet(string $cacheKey, Closure $callback): void
    {
        $this->cacheType = new CacheSet($this->cacheExpire, $this->cacheEmptyExpire);
        $this->init($cacheKey, $callback);
    }

    /**
     * @throws \Papaedu\Extension\Exceptions\EmptyCacheException
     */
    abstract protected function get(string $cacheKey, Closure $callback);

    abstract protected function init(string $cacheKey, Closure $callback);
}
