<?php

namespace Papaedu\Extension\TencentCloud\Kernel\Contracts;

use Closure;

interface NotifyInterface
{
    public function handle(Closure $closure);
}
