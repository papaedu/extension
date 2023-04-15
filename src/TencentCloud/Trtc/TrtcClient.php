<?php

namespace Papaedu\Extension\TencentCloud\Trtc;

use Papaedu\Extension\TencentCloud\Kernel\TencentCloudClient;
use TencentCloud\Common\Credential;
use TencentCloud\Trtc\V20190722\TrtcClient as TencentTrtcClient;

/**
 * @method \TencentCloud\Trtc\V20190722\TrtcClient getClient()
 */
class TrtcClient extends TencentCloudClient
{
    protected function initClient()
    {
        $credential = new Credential($this->config['secret_id'], $this->config['secret_key']);
        $this->client = new TencentTrtcClient($credential, $this->config['region']);
    }

    public function checkSign(string $body, string $sign): bool
    {
        return $sign === base64_encode(hash_hmac('sha256', $body, $this->config['callback_key'], true));
    }
}
