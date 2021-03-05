<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class BlackListAdd extends TimRequest
{
    /**
     * BlackListAdd constructor.
     *
     * @param  string  $fromAccount
     * @param  array  $toAccount
     */
    public function __construct(string $fromAccount, array $toAccount)
    {
        $this->setFromAccount($fromAccount)->setToAccount($toAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/sns/black_list_add';
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): BlackListAdd
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  array  $toAccount
     * @return $this
     */
    public function setToAccount(array $toAccount): BlackListAdd
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }
}
