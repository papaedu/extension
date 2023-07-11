<?php

namespace Papaedu\Extension\TencentCloud\Tiw;

use Closure;
use Papaedu\Extension\TencentCloud\Kernel\TencentCloudClient;
use Symfony\Component\HttpFoundation\Response;
use TencentCloud\Common\Credential;
use TencentCloud\Tiw\V20190919\TiwClient as TencentTiwClient;

/**
 * @method \TencentCloud\Tiw\V20190919\TiwClient getClient()
 */
class TiwClient extends TencentCloudClient
{
    protected function initClient(): void
    {
        $credential = new Credential($this->config['secret_id'], $this->config['secret_key']);
        $this->client = new TencentTiwClient($credential, $this->config['region']);
    }

    /**
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException
     */
    public function notify(Closure $closure): Response
    {
        return (new Notify())->handle($closure);
    }

    public function checkTranscodeSign(string $body, string $sign): bool
    {
        return $this->checkSign($body, $sign, $this->config['transcode_callback_key']);
    }

    public function checkRecordSign(string $expireTime, string $sign): bool
    {
        return $this->checkSign($expireTime, $sign, $this->config['record_callback_key']);
    }

    public function checkPushSign(string $expireTime, string $sign): bool
    {
        return $this->checkSign($expireTime, $sign, $this->config['push_callback_key']);
    }

    protected function checkSign(string $expireTime, string $sign, string $key): bool
    {
        return $sign === md5($key.$expireTime);
    }
}
