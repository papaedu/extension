<?php

namespace Papaedu\Extension\TencentCloud\Tim;

use Papaedu\Extension\TencentCloud\Kernel\Client;
use Papaedu\Extension\TencentCloud\Kernel\HttpClient\TlsHttpClient;
use Papaedu\Extension\TencentCloud\Kernel\Sign\TlsSign;

class TimClient extends Client
{
    /**
     * @var string
     */
    protected string $baseUri = 'https://console.tim.qq.com/';

    /**
     * @var array
     */
    protected array $config;

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
     * @param  array  $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
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
                $this->config['sdk_app_id'],
                $this->config['identifier'],
                $tlsSign->getTlsSign(),
                $this->baseUri
            );
        }

        return $this->client;
    }

    /**
     * @param  bool  $isAdmin
     * @return \Papaedu\Extension\TencentCloud\Kernel\Sign\TlsSign
     */
    public function getTlsSign(bool $isAdmin = false): TlsSign
    {
        if (!$this->tlsSign instanceof TlsSign) {
            $this->tlsSign = new TlsSign(
                $isAdmin,
                $this->config['sdk_app_id'],
                $this->config['sign']['version'],
                $this->config['sign']['key'],
                $this->config['sign']['private_key'],
                $this->config['sign']['public_key'],
            );
        }

        return $this->tlsSign;
    }
}
