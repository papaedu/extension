<?php

namespace Papaedu\Extension\Wechat\Kernel\Contracts;

interface MessageHandlerInterface
{
    public function handle($payload = null);
}
