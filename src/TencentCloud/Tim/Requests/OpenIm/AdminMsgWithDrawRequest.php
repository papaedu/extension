<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class AdminMsgWithDrawRequest extends TimRequest
{
    /**
     * AdminMsgWithDrawRequest constructor.
     *
     * @param  string  $fromAccount
     * @param  string  $toAccount
     * @param  string  $msgKey
     */
    public function __construct(string $fromAccount, string $toAccount, string $msgKey)
    {
        $this->setFromAccount($fromAccount)
            ->setToAccount($toAccount)
            ->setMsgKey($msgKey);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/openim/admin_msgwithdraw';
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): static
    {
        if ($fromAccount) {
            $this->setParameter('From_Account', $fromAccount);
        }

        return $this;
    }

    /**
     * @param  string  $toAccounts
     * @return $this
     */
    public function setToAccount(string $toAccounts): static
    {
        $this->setParameter('To_Account', $toAccounts);

        return $this;
    }

    /**
     * @param  string  $msgKey
     * @return $this
     */
    public function setMsgKey(string $msgKey): static
    {
        $this->setParameter('MsgKey', $msgKey);

        return $this;
    }
}
