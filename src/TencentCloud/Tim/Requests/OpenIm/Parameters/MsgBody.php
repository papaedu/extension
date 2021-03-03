<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class MsgBody extends Parameter
{
    /**
     * MsgBody constructor.
     *
     * @param  string  $msgType
     * @param  string  $msgContentText
     */
    public function __construct(
        string $msgType,
        string $msgContentText
    ) {
        $this->setMsgType($msgType, $msgContentText);
    }

    /**
     * @param $msgType
     * @param $msgContentText
     */
    public function setMsgType($msgType, $msgContentText)
    {
        $this->parameters[] = [
            'MsgType' => $msgType,
            'MsgContent' => [
                'Text' => $msgContentText,
            ],
        ];
    }
}
