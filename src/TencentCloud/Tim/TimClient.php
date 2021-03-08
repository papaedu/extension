<?php

namespace Papaedu\Extension\TencentCloud\Tim;

use Papaedu\Extension\TencentCloud\Kernel\Client;
use Papaedu\Extension\TencentCloud\Kernel\HttpClient\TlsHttpClient;
use Papaedu\Extension\TencentCloud\Kernel\Sign\TlsSign;

/**
 * Class TimClient
 *
 * @package Papaedu\Extension\TencentCloud\Tim
 */
class TimClient extends Client
{
    /**
     * @var string
     */
    protected string $baseUri = 'https://console.tim.qq.com/';

    /**
     * @var bool
     */
    private bool $isAdmin;

    /**
     * @var string
     */
    protected string $sdkAppId;

    /**
     * @var string
     */
    protected string $identifier;

    /**
     * @var \Papaedu\Extension\TencentCloud\Kernel\HttpClient\TlsHttpClient|null
     */
    protected ?TlsHttpClient $client = null;

    /**
     * @var \Papaedu\Extension\TencentCloud\Kernel\Sign\TlsSign|null
     */
    protected ?TlsSign $tlsSign = null;

    /**
     * TimClient constructor.
     *
     * @param  bool  $isAdmin
     */
    public function __construct(bool $isAdmin = false)
    {
        $this->sdkAppId = config('extension.tencent_cloud.tim.sdk_app_id');
        $this->identifier = config('extension.tencent_cloud.tim.identifier');
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return \Papaedu\Extension\TencentCloud\Kernel\HttpClient\TlsHttpClient
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException
     */
    public function getClient(): TlsHttpClient
    {
        if (!$this->client instanceof TlsHttpClient) {
            $tlsSign = $this->getTlsSign();

            $this->client = new TlsHttpClient(
                $this->sdkAppId,
                $this->identifier,
                $tlsSign->getTlsSign(),
                $this->baseUri
            );
        }

        return $this->client;
    }

    /**
     * @return \Papaedu\Extension\TencentCloud\Kernel\Sign\TlsSign
     */
    public function getTlsSign(): TlsSign
    {
        if (!$this->tlsSign instanceof TlsSign) {
            $this->tlsSign = new TlsSign(
                $this->isAdmin,
                $this->sdkAppId,
                config('extension.tencent_cloud.tim.sign.version'),
                config('extension.tencent_cloud.tim.sign.key'),
                config('extension.tencent_cloud.tim.sign.private_key', ''),
                config('extension.tencent_cloud.tim.sign.public_key', ''),
            );
        }

        return $this->tlsSign;
    }
}
