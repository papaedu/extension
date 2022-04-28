<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\ImOpenLoginSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\ImOpenLoginSvc\Parameters\AccountItem;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class AccountDeleteRequest extends TimRequest
{
    /**
     * AccountDeleteRequest constructor.
     *
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\ImOpenLoginSvc\Parameters\AccountItem  $accountItem
     */
    public function __construct(AccountItem $accountItem)
    {
        $this->setDeleteItem($accountItem);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/im_open_login_svc/account_delete';
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\ImOpenLoginSvc\Parameters\AccountItem  $accountItem
     * @return $this
     */
    public function setDeleteItem(AccountItem $accountItem): self
    {
        $this->setParameter('DeleteItem', $accountItem);

        return $this;
    }
}
