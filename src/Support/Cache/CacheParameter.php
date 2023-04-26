<?php

namespace Papaedu\Extension\Support;

trait CacheParameter
{
    public function setCacheExpire(int $cacheExpire): self
    {
        $this->cacheExpire = $cacheExpire;

        return $this;
    }

    public function setCacheEmptyExpire(int $cacheEmptyExpire): self
    {
        $this->cacheEmptyExpire = $cacheEmptyExpire;

        return $this;
    }
}
