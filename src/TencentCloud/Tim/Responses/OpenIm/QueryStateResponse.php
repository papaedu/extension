<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class QueryStateResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getQueryResult(): array
    {
        return $this->content['QueryResult'];
    }

    /**
     * @return array
     */
    public function getErrorList(): array
    {
        return $this->content['ErrorList'];
    }
}
