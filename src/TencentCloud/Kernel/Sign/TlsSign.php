<?php

namespace Papaedu\Extension\TencentCloud\Kernel\Sign;

use Illuminate\Support\Facades\Cache;
use Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException;
use Papaedu\Extension\TencentCloud\Kernel\Contracts\TlsSignInterface;

class TlsSign
{
    /**
     * @var bool
     */
    private bool $isAdmin;

    /**
     * @var string
     */
    private string $sdkAppId;

    /**
     * @var string
     */
    private string $version;

    /**
     * @var string
     */
    private string $key;

    /**
     * @var string
     */
    private string $privateKey;

    /**
     * @var string
     */
    private string $publicKey;

    /**
     * @var \Papaedu\Extension\TencentCloud\Kernel\Contracts\TlsSignInterface|null
     */
    private ?TlsSignInterface $tlsSign = null;

    public function __construct(
        bool $isAdmin,
        string $sdkAppId,
        string $version,
        string $key,
        string $privateKey,
        string $publicKey
    ) {
        $this->isAdmin = $isAdmin;
        $this->sdkAppId = $sdkAppId;
        $this->version = $version;
        $this->key = $key;
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
    }

    /**
     * @return \Papaedu\Extension\TencentCloud\Kernel\Contracts\TlsSignInterface
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException
     */
    public function getTlsSign()
    {
        if (!$this->tlsSign instanceof TlsSignInterface) {
            if (empty($this->sdkAppId)) {
                throw new InvalidArgumentException('sdkAppId is empty.');
            }
            if ('v1' == $this->version) {
                if (empty($this->privateKey)) {
                    throw new InvalidArgumentException('privateKey is empty.');
                }
                if (empty($this->publicKey)) {
                    throw new InvalidArgumentException('publicKey is empty.');
                }

                $this->tlsSign = new TlsSignV1($this->sdkAppId, $this->privateKey, $this->publicKey);
            } elseif ('v2' == $this->version) {
                if (empty($this->key)) {
                    throw new InvalidArgumentException('key is empty.');
                }

                $this->tlsSign = new TlsSignV2($this->sdkAppId, $this->key);
            } else {
                throw new InvalidArgumentException("Sign Version {$this->version} not exist.");
            }
        }

        return $this->tlsSign;
    }

    /**
     * @param  string  $identifier
     * @param  int  $ttl
     * @return string
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidConfigException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidSignException
     */
    public function sign(string $identifier, int $ttl = 2592000): string
    {
        if ($this->isAdmin) {
            return Cache::remember(
                "tencent_cloud.tim.{$identifier}",
                now()->addSeconds($ttl),
                function ($identifier, $ttl) {
                    return $this->getTlsSign()->sign($identifier, $ttl);
                }
            );
        }

        return $this->getTlsSign()->sign($identifier, $ttl);
    }
}
