<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Profile;

use Papaedu\Extension\TencentCloud\Tim\Requests\Profile\Parameters\ProfileItem;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class PortraitSet extends TimRequest
{
    /**
     * PortraitSet constructor.
     *
     * @param  string  $fromAccount
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Profile\Parameters\ProfileItem  $profileItem
     */
    public function __construct(string $fromAccount, ProfileItem $profileItem)
    {
        $this->setFromAccount($fromAccount)->setProfileItem($profileItem);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/profile/portrait_set';
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): PortraitSet
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Profile\Parameters\ProfileItem  $profileItem
     * @return $this
     */
    public function setProfileItem(ProfileItem $profileItem): PortraitSet
    {
        $this->setParameter('ProfileItem', $profileItem);

        return $this;
    }
}
