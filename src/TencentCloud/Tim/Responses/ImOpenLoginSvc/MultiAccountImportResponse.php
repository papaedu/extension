<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\ImOpenLoginSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class MultiAccountImportResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getFailAccounts(): array
    {
        return $this->content['FailAccounts'];
    }
}
