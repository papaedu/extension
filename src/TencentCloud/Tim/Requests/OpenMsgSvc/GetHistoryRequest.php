<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenMsgSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class GetHistoryRequest extends TimRequest
{
    /**
     * GetHistoryRequest constructor.
     *
     * @param  string  $chatType
     * @param  string  $msgTime
     */
    public function __construct(string $chatType, string $msgTime)
    {
        $this->setChatType($chatType)
            ->setMsgTime($msgTime);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/open_msg_svc/get_history';
    }

    /**
     * @param  string  $chatType
     * @return $this
     */
    public function setChatType(string $chatType): self
    {
        $this->setParameter('ChatType', $chatType);

        return $this;
    }

    /**
     * @param  string  $msgTime
     * @return $this
     */
    public function setMsgTime(string $msgTime): self
    {
        $this->setParameter('MsgTime', $msgTime);

        return $this;
    }
}
