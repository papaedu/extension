<?php

namespace Papaedu\Extension\Channels\TencentCloud\IM;

class TencentCloudImMessage
{
    /**
     * @var string
     */
    private string $fromAccount = '';

    /**
     * @var string
     */
    private string $fromAccountName = '';

    /**
     * @var string
     */
    private string $text = '';

    /**
     * @var array
     */
    private array $customMessage = [];

    /**
     * @var array
     */
    private array $forbidCallbackControl = [];

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): TencentCloudImMessage
    {
        $this->fromAccount = $fromAccount;

        return $this;
    }

    /**
     * @param  string  $fromAccountName
     * @return $this
     */
    public function setFromAccountName(string $fromAccountName): TencentCloudImMessage
    {
        $this->fromAccountName = $fromAccountName;

        return $this;
    }

    /**
     * @param  string  $text
     * @return $this
     */
    public function setText(string $text): TencentCloudImMessage
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param  array  $customMessage
     * @return $this
     */
    public function setCustomMessage(array $customMessage): TencentCloudImMessage
    {
        $this->customMessage = $customMessage;

        return $this;
    }

    /**
     * @param  array  $forbidCallbackControl
     * @return $this
     */
    public function setForbidCallbackControl(array $forbidCallbackControl): TencentCloudImMessage
    {
        $this->forbidCallbackControl = $forbidCallbackControl;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromAccount(): string
    {
        return $this->fromAccount;
    }

    /**
     * @return string
     */
    public function getFromAccountName(): string
    {
        return $this->fromAccountName;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getCustomMessage(): array
    {
        return $this->customMessage;
    }

    /**
     * @return array
     */
    public function getForbidCallbackControl(): array
    {
        return $this->forbidCallbackControl;
    }
}
