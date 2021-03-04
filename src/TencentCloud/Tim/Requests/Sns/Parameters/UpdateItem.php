<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class UpdateItem extends Parameter
{
    /**
     * UpdateItem constructor.
     *
     * @param  string  $toAccount
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\SnsItem  $snsItem
     */
    public function __construct(string $toAccount, SnsItem $snsItem)
    {
        $this->setToAccount($toAccount)->setSnsItem($snsItem);
    }

    /**
     * @param  string  $toAccount
     * @return $this
     */
    public function setToAccount(string $toAccount): UpdateItem
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\SnsItem  $snsItem
     * @return $this
     */
    public function setSnsItem(SnsItem $snsItem): UpdateItem
    {
        $this->setParameter('SnsItem', $snsItem);

        return $this;
    }
}
