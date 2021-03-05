<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class BlackListDelete extends TimRequest
{
    /**
     * BlackListDelete constructor.
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
        return 'v4/sns/black_list_delete';
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): BlackListDelete
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  array  $toAccount
     * @return $this
     */
    public function setToAccount(array $toAccount): BlackListDelete
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }
}
