<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class AddFriendItem extends Parameter
{
    /**
     * AddFriendItem constructor.
     *
     * @param  string  $toAccount
     */
    public function __construct(string $toAccount)
    {
        $this->setToAccount($toAccount);
    }

    /**
     * @param  string  $toAccount
     * @return $this
     */
    public function setToAccount(string $toAccount): AddFriendItem
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }

    /**
     * @param  string  $remark
     * @return $this
     */
    public function setRemark(string $remark): AddFriendItem
    {
        $this->setParameter('Remark', $remark);

        return $this;
    }

    /**
     * @param  string  $remarkTime
     * @return $this
     */
    public function setRemarkTime(string $remarkTime): AddFriendItem
    {
        $this->setParameter('RemarkTime', $remarkTime);

        return $this;
    }

    /**
     * @param  string  $groupName
     * @return $this
     */
    public function setGroupName(string $groupName): AddFriendItem
    {
        $this->setParameter('GroupName', $groupName);

        return $this;
    }

    /**
     * @param  string  $addSource
     * @return $this
     */
    public function setAddSource(string $addSource): AddFriendItem
    {
        $this->setParameter('AddSource', $addSource);

        return $this;
    }

    /**
     * @param  string  $addWording
     * @return $this
     */
    public function setAddWording(string $addWording): AddFriendItem
    {
        $this->setParameter('AddWording', $addWording);

        return $this;
    }

    /**
     * @param  int  $addTime
     * @return $this
     */
    public function setAddTime(int $addTime): AddFriendItem
    {
        $this->setParameter('AddTime', $addTime);

        return $this;
    }

    public function setCustomItem()
    {
        $this->setParameter('CustomItem',);

        return $this;
    }
}
