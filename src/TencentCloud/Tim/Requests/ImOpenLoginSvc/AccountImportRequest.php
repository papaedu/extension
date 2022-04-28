<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\ImOpenLoginSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class AccountImportRequest extends TimRequest
{
    /**
     * AccountImportRequest constructor.
     *
     * @param  string  $identifier
     * @param  string  $nick
     * @param  string  $faceUrl
     */
    public function __construct(string $identifier, string $nick = '', string $faceUrl = '')
    {
        $this->setIdentifier($identifier)
            ->setNick($nick)
            ->setFaceUrl($faceUrl);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/im_open_login_svc/account_import';
    }

    /**
     * @param  string  $identifier
     * @return $this
     */
    public function setIdentifier(string $identifier): self
    {
        $this->setParameter('Identifier', $identifier);

        return $this;
    }

    /**
     * @param  string  $nick
     * @return $this
     */
    public function setNick(string $nick): self
    {
        $this->setParameter('Nick', $nick);

        return $this;
    }

    /**
     * @param  string  $faceUrl
     * @return $this
     */
    public function setFaceUrl(string $faceUrl): self
    {
        $this->setParameter('FaceUrl', $faceUrl);

        return $this;
    }
}
