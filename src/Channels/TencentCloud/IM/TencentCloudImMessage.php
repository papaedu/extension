<?php

namespace Papaedu\Extension\Channels\TencentCloud\IM;

use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums\ForbidCallbackControl;

class TencentCloudImMessage
{
    protected string $fromAccount = '';

    protected string $fromAccountName = '';

    protected string $text = '';

    protected array $customMessage = [];

    protected array $forbidCallbackControl = [];

    public function setFromAccount(string $fromAccount): static
    {
        $this->fromAccount = $fromAccount;

        return $this;
    }

    public function setFromAccountName(string $fromAccountName): static
    {
        $this->fromAccountName = $fromAccountName;

        return $this;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function setCustomMessage(array $customMessage): static
    {
        $this->customMessage = $customMessage;

        return $this;
    }

    public function setForbidCallbackControl(ForbidCallbackControl ...$forbidCallbackControl): static
    {
        $this->forbidCallbackControl = array_map(fn ($value) => $value->value, $forbidCallbackControl);

        return $this;
    }

    public function getFromAccount(): string
    {
        return $this->fromAccount;
    }

    public function getFromAccountName(): string
    {
        return $this->fromAccountName;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCustomMessage(): array
    {
        return $this->customMessage;
    }

    public function getForbidCallbackControl(): array
    {
        return $this->forbidCallbackControl;
    }
}
