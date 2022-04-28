<?php

namespace Papaedu\Extension\Wechat\Kernel\Contracts;

interface ContentInterface
{
    public function getContents($payload = null): array;
}
