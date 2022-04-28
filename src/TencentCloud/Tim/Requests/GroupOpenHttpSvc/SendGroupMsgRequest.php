<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums\ForbidCallbackControl;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class SendGroupMsgRequest extends TimRequest
{
    /**
     * SendGroupMsgRequest constructor.
     *
     * @param  string  $groupId
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     * @param  int  $random
     */
    public function __construct(string $groupId, MsgBody $msgBody, int $random = 0)
    {
        if (! $random) {
            $random = random_int(1, 9999999);
        }

        $this->setGroupId($groupId)
            ->setRandom($random)
            ->setMsgBody($msgBody);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/send_group_msg';
    }

    public function setGroupId(string $groupId): static
    {
        $this->setParameter('GroupId', $groupId);

        return $this;
    }

    public function setRandom(int $random): static
    {
        $this->setParameter('Random', $random);

        return $this;
    }

    public function setMsgPriority(string $msgPriority): static
    {
        $this->setParameter('MsgPriority', $msgPriority);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     * @return $this
     */
    public function setMsgBody(MsgBody $msgBody): static
    {
        $this->setParameter('MsgBody', $msgBody);

        return $this;
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): static
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo  $offlinePushInfo
     * @return $this
     */
    public function setOfflinePushInfo(OfflinePushInfo $offlinePushInfo): static
    {
        $this->setParameter('OfflinePushInfo', $offlinePushInfo);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums\ForbidCallbackControl  ...$forbidCallbackControl
     * @return $this
     */
    public function setForbidCallbackControl(ForbidCallbackControl ...$forbidCallbackControl): static
    {
        $this->setParameter('ForbidCallbackControl', array_map(fn ($value) => $value->value, $forbidCallbackControl));

        return $this;
    }

    /**
     * @param  int  $onlineOnlyFlag
     * @return $this
     */
    public function setOnlineOnlyFlag(int $onlineOnlyFlag): static
    {
        $this->setParameter('OnlineOnlyFlag', $onlineOnlyFlag);

        return $this;
    }
}
