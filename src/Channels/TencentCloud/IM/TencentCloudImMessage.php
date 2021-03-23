<?php

namespace Papaedu\Extension\Channels\TencentCloud\IM;

class TencentCloudImMessage
{
    public $fromAccount;

    public $text;

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): self
    {
        $this->fromAccount = $fromAccount;

        return $this;
    }

    /**
     * @param  string  $text
     * @return $this
     */
    public function setText(string $text): self
    {
        $this->text = $text;

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
    public function getText(): string
    {
        return $this->text;
    }
}
