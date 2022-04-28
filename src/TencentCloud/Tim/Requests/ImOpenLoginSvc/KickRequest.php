<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\ImOpenLoginSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class KickRequest extends TimRequest
{
    /**
     * KickRequest constructor.
     *
     * @param  string  $identifier
     */
    public function __construct(string $identifier)
    {
        $this->setIdentifier($identifier);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/im_open_login_svc/kick';
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
}
