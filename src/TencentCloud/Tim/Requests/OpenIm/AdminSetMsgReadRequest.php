<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class AdminSetMsgReadRequest extends TimRequest
{
    /**
     * AdminSetMsgReadRequest constructor.
     *
     * @param  string  $reportAccount
     * @param  string  $peerAccount
     */
    public function __construct(string $reportAccount, string $peerAccount)
    {
        $this->setReportAccount($reportAccount)
            ->setPeerAccount($peerAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/openim/admin_set_msg_read';
    }

    /**
     * @param  string  $reportAccount
     * @return $this
     */
    public function setReportAccount(string $reportAccount): static
    {
        $this->setParameter('Report_Account', $reportAccount);

        return $this;
    }

    /**
     * @param  string  $peerAccount
     * @return $this
     */
    public function setPeerAccount(string $peerAccount): static
    {
        $this->setParameter('Peer_Account', $peerAccount);

        return $this;
    }
}
