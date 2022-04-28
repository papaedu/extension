<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums\SyncFromOldSystem;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImportMsgRequest extends TimRequest
{
    /**
     * ImportMsgRequest constructor.
     *
     * @param  int  $syncFromOldSystem
     * @param  string  $fromAccount
     * @param  string  $toAccount
     * @param  int  $msgRandom
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     */
    public function __construct(
        int $syncFromOldSystem,
        string $fromAccount,
        string $toAccount,
        int $msgRandom,
        MsgBody $msgBody
    ) {
        $this->setSyncFromOldSystem($syncFromOldSystem)
            ->setFromAccount($fromAccount)
            ->setToAccount($toAccount)
            ->setMsgRandom($msgRandom)
            ->setMsgRandom($msgRandom)
            ->setMsgBody($msgBody);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/openim/importmsg';
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums\SyncFromOldSystem  $syncFromOldSystem
     * @return $this
     */
    public function setSyncFromOldSystem(SyncFromOldSystem $syncFromOldSystem): static
    {
        $this->setParameter('SyncFromOldSystem', $syncFromOldSystem);

        return $this;
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): static
    {
        if ($fromAccount) {
            $this->setParameter('From_Account', $fromAccount);
        }

        return $this;
    }

    /**
     * @param  string  $toAccounts
     * @return $this
     */
    public function setToAccount(string $toAccounts): static
    {
        $this->setParameter('To_Account', $toAccounts);

        return $this;
    }

    /**
     * @param  int  $msgRandom
     * @return $this
     */
    public function setMsgRandom(int $msgRandom): static
    {
        $this->setParameter('MsgRandom', $msgRandom);

        return $this;
    }

    /**
     * @param  int  $msgTimestamp
     * @return $this
     */
    public function setMsgTimestamp(int $msgTimestamp): static
    {
        $this->setParameter('MsgTimeStamp', $msgTimestamp);

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
}
