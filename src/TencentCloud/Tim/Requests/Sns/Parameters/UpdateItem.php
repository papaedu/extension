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
        $this->setUpdateItem($toAccount, $snsItem);
    }

    /**
     * @param  string  $toAccount
     * @return $this
     */
    public function setUpdateItem(string $toAccount, SnsItem $snsItem): self
    {
        $this->parameters[] = [
            'To_Account' => $toAccount,
            'SnsItem' => $snsItem->getParameters(),
        ];

        return $this;
    }
}
