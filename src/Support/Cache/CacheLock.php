<?php

namespace Papaedu\Extension\Support;

use Closure;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Papaedu\Extension\Exceptions\BusinessException;

class CacheLock extends CacheAbstract
{
    use CacheLockParameter;

    protected string $cacheLockKeyPrefix = 'lock:';

    protected int $cacheLockWaitSeconds = 5;

    protected int $cacheLockHoldSeconds = 2;

    /**
     * @throws \Papaedu\Extension\Exceptions\EmptyCacheException
     * @throws \Papaedu\Extension\Exceptions\BusinessException
     */
    protected function get(string $cacheKey, Closure $callback): mixed
    {
        $cache = $this->cacheType->get($cacheKey);
        if (! empty($cache)) {
            return $cache;
        }

        return $this->cacheLock($cacheKey, function () use ($cacheKey, $callback) {
            $cache = $this->cacheType->get($cacheKey);
            if (! empty($cache)) {
                return $cache;
            }

            $data = $callback();
            $this->cacheType->set($cacheKey, $data);

            return $data;
        });
    }

    /**
     * @throws \Papaedu\Extension\Exceptions\BusinessException
     */
    protected function init(string $cacheKey, Closure $callback): void
    {
        if ($this->cacheType->exists($cacheKey)) {
            return;
        }

        $this->cacheLock($cacheKey, function () use ($cacheKey, $callback) {
            if ($this->cacheType->exists($cacheKey)) {
                return;
            }

            $data = $callback();
            $this->cacheType->set($cacheKey, $data);
        });
    }

    /**
     * @throws \Papaedu\Extension\Exceptions\BusinessException
     */
    public function cacheLock(string $cacheKey, callable $callback = null): mixed
    {
        $cacheLock = Cache::lock($this->cacheLockKeyPrefix.$cacheKey, $this->cacheLockWaitSeconds, Str::uuid()->toString());
        try {
            return $cacheLock->block($this->cacheLockHoldSeconds, $callback);
        } catch (LockTimeoutException $e) {
            throw new BusinessException(trans('bad_request.get_lock_failed'));
        }
    }
}
