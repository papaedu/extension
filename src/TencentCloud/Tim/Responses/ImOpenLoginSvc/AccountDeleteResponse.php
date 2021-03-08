<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\ImOpenLoginSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class AccountDeleteResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getResultItem(): array
    {
        return $this->content['ResultItem'];
    }
}
