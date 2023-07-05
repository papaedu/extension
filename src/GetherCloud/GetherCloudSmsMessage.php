<?php

namespace Papaedu\Extension\GetherCloud;

class GetherCloudSmsMessage
{
    protected string $templateCode = '';

    protected array $params = [];

    public function setTemplateCode(string $templateCode): self
    {
        $this->templateCode = $templateCode;

        return $this;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    public function getTemplateCode(): string
    {
        return $this->templateCode;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
