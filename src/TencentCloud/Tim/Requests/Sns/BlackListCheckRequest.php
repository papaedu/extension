<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class BlackListCheckRequest extends TimRequest
{
    /**
     * BlockListCheck constructor.
     *
     * @param  string  $fromAccount
     * @param  array  $toAccount
     * @param  string  $checkType
     */
    public function __construct(string $fromAccount, array $toAccount, string $checkType)
    {
        $this->setFromAccount($fromAccount)
            ->setToAccount($toAccount)
            ->setCheckType($checkType);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/sns/black_list_check';
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): self
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  array  $toAccount
     * @return $this
     */
    public function setToAccount(array $toAccount): self
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }

    /**
     * @param  string  $checkType
     * @return $this
     */
    public function setCheckType(string $checkType): self
    {
        $this->setParameter('CheckType', $checkType);

        return $this;
    }
}
