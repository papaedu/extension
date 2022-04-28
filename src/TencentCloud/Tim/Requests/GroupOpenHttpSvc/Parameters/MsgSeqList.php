<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

/**
 * Class MsgSeqList
 *
 * @package Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters
 *
 * TODO: Change array or object.
 */
class MsgSeqList extends Parameter
{
    /**
     * @param  int  $msgSeq
     * @return $this
     */
    public function setMsgSeq(int $msgSeq): self
    {
        $this->parameters[] = [
            'MsgSeq' => $msgSeq,
        ];

        return $this;
    }
}
