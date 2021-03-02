<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class QueryStateRequest extends TimRequest
{
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
     * @param  array  $toAccounts
     * @return $this
     */
    public function setToAccount(array $toAccounts): QueryStateRequest
    {
        $this->setParameter('To_Account', $toAccounts);

        return $this;
    }

    /**
     * @param  bool  $isNeedDetail
     * @return $this
     */
    public function setIsNeedDetail(bool $isNeedDetail): QueryStateRequest
    {
        $this->setParameter('IsNeedDetail', intval($isNeedDetail));

        return $this;
    }
}
