<?php

namespace Papaedu\Extension\Support\Cache;

trait CacheLockParameter
{
    public function setCacheLockKeyPrefix(string $cacheLockKeyPrefix): self
    {
        $this->cacheLockKeyPrefix = $cacheLockKeyPrefix;

        return $this;
    }

    public function setCacheLockWaitSeconds(int $cacheLockWaitSeconds): self
    {
        $this->cacheLockWaitSeconds = $cacheLockWaitSeconds;

        return $this;
    }

    public function setCacheLockHoldSeconds(int $cacheLockHoldSeconds): self
    {
        $this->cacheLockHoldSeconds = $cacheLockHoldSeconds;

        return $this;
    }
}
