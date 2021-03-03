<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class AdminSetMsgRead extends TimRequest
{
    /**
     * AdminSetMsgRead constructor.
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
    public function setReportAccount(string $reportAccount): AdminSetMsgRead
    {
        $this->setParameter('Report_Account', $reportAccount);

        return $this;
    }

    /**
     * @param  string  $peerAccount
     * @return $this
     */
    public function setPeerAccount(string $peerAccount): AdminSetMsgRead
    {
        $this->setParameter('Peer_Account', $peerAccount);

        return $this;
    }
}
