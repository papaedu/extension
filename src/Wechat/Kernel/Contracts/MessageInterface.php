<?php

namespace Papaedu\Extension\Wechat\Kernel\Contracts;

interface MessageInterface
{
    public function getType(): string;

    public function transformForJsonRequest(): array;

    public function transformToXml(): string;

    public function toXmlArray(): array;
}
