<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\OpenMsgSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GetHistoryResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getFile(): array
    {
        return $this->content['File'];
    }
}
