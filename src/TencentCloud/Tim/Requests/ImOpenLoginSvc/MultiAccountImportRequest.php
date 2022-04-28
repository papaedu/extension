<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\ImOpenLoginSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class MultiAccountImportRequest extends TimRequest
{
    /**
     * MultiAccountImportRequest constructor.
     *
     * @param  array  $accounts
     */
    public function __construct(array $accounts)
    {
        $this->setAccounts($accounts);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/im_open_login_svc/multiaccount_import';
    }

    /**
     * @param  array  $accounts
     * @return $this
     */
    public function setAccounts(array $accounts): self
    {
        $this->setParameter('Accounts', $accounts);

        return $this;
    }
}
