<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class ImportGroupMsgResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getImportMsgResult(): array
    {
        return $this->content['ImportMsgResult'];
    }
}
