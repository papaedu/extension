<?php

namespace Papaedu\Extension\TencentCloud\Ocr;

use Papaedu\Extension\TencentCloud\Kernel\TencentCloudClient;
use TencentCloud\Common\Credential;
use TencentCloud\Ocr\V20181119\OcrClient as TencentOcrClient;

/**
 * @method \TencentCloud\Ocr\V20181119\OcrClient getClient()
 */
class OcrClient extends TencentCloudClient
{
    protected function initClient(): void
    {
        $credential = new Credential($this->config['secret_id'], $this->config['secret_key']);
        $this->client = new TencentOcrClient($credential, $this->config['region']);
    }
}
