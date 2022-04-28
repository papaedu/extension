<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class QueryStateRequest extends TimRequest
{
    /**
     * QueryStateRequest constructor.
     *
     * @param  array  $toAccount
     * @param  bool  $isNeedDetail
     */
    public function __construct(array $toAccount, bool $isNeedDetail = false)
    {
        $this->setToAccount($toAccount)
            ->setIsNeedDetail($isNeedDetail);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/openim/querystate';
    }

    /**
     * @param  array  $toAccount
     * @return $this
     */
    public function setToAccount(array $toAccount): static
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }

    /**
     * @param  bool  $isNeedDetail
     * @return $this
     */
    public function setIsNeedDetail(bool $isNeedDetail): static
    {
        $this->setParameter('IsNeedDetail', intval($isNeedDetail));

        return $this;
    }
}
