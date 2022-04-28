<?php

namespace Papaedu\Extension\TencentCloud\Kernel\Contracts;

interface CallbackInterface
{
    /**
     * @param  \Papaedu\Extension\TencentCloud\Kernel\Contracts\ResponseInterface  $response
     * @return mixed
     */
    public function success(ResponseInterface $response);

    /**
     * @param  mixed  $reason
     * @return mixed
     */
    public function error($reason);
}
