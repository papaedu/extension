<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\ImOpenLoginSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\ImOpenLoginSvc\Parameters\AccountItem;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class AccountCheckRequest extends TimRequest
{
    /**
     * AccountCheckRequest constructor.
     *
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\ImOpenLoginSvc\Parameters\AccountItem  $accountItem
     */
    public function __construct(AccountItem $accountItem)
    {
        $this->setCheckItem($accountItem);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/im_open_login_svc/account_check';
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\ImOpenLoginSvc\Parameters\AccountItem  $accountItem
     * @return $this
     */
    public function setCheckItem(AccountItem $accountItem): self
    {
        $this->setParameter('CheckItem', $accountItem);

        return $this;
    }
}
