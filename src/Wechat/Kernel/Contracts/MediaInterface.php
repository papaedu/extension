<?php

namespace Papaedu\Extension\Wechat\Kernel\Contracts;

interface MediaInterface extends MessageInterface
{
    public function getMediaId(): string;
}
