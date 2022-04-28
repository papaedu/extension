<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class AddFriendItem extends Parameter
{
    /**
     * AddFriendItem constructor.
     *
     * @param  string  $toAccount
     * @param  string  $addSource
     * @param  string  $remark
     * @param  string  $groupName
     * @param  string  $addWording
     * @param  int  $addTime
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\CustomItem|null  $customItem
     */
    public function __construct(
        string $toAccount,
        string $addSource,
        string $remark = '',
        string $groupName = '',
        string $addWording = '',
        int $addTime = 0,
        ?CustomItem $customItem = null
    ) {
        $this->setAddFriend($toAccount, $addSource, $remark, $groupName, $addWording, $addTime, $customItem);
    }

    /**
     * @param  string  $toAccount
     * @param  string  $addSource
     * @param  string  $remark
     * @param  string  $groupName
     * @param  string  $addWording
     * @param  int  $addTime
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\CustomItem|null  $customItem
     * @return $this
     */
    public function setAddFriend(
        string $toAccount,
        string $addSource,
        string $remark = '',
        string $groupName = '',
        string $addWording = '',
        int $addTime = 0,
        ?CustomItem $customItem = null
    ): self {
        $this->parameters[] = array_filter([
            'To_Account' => $toAccount,
            'AddSource' => "AddSource_Type_{$addSource}",
            'Remark' => $remark,
            'GroupName' => $groupName,
            'AddWording' => $addWording,
            'AddTime' => $addTime,
            'CustomItem' => $customItem,
        ]);

        return $this;
    }
}
