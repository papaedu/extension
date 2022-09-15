<?php

namespace Papaedu\Extension\TencentCloud\Trtc;

use Papaedu\Extension\TencentCloud\Kernel\TencentCloudClient;
use TencentCloud\Common\Credential;
use TencentCloud\Trtc\V20190722\TrtcClient as TencentTrtcClient;

/**
 * @method \Papaedu\Extension\TencentCloud\Trtc\TrtcClient getClient()
 */
class TrtcClient extends TencentCloudClient
{
    protected function initClient()
    {
        $credential = new Credential($this->config['secret_id'], $this->config['secret_key']);
        $this->client = new TencentTrtcClient($credential, $this->config['region']);
    }

    public function checkRecordSign(string $body, string $sign): bool
    {
        return $this->checkSign($body, $sign, $this->config['record_callback_key']);
    }

    public function checkCommonSign(string $body, string $sign): bool
    {
        return $this->checkSign($body, $sign, $this->config['common_callback_key']);
    }

    protected function checkSign(string $body, string $sign, string $key): bool
    {
        return $sign === base64_encode(hash_hmac('sha256', $body, $key, true));
    }
}
