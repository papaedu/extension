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
        if (! $this->tlsSign instanceof TlsSignInterface) {
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

    /**
     * @param  string  $userId
     * @param  string  $roomId
     * @param  int  $expire
     * @return string
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidConfigException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidSignException
     */
    public function privateMapKey(string $userId, string $roomId, int $expire = 300): string
    {
        //视频校验位需要用到的字段
        /*
            cVer    unsigned char/1 版本号，填0
            wAccountLen unsigned short /2   第三方自己的帐号长度
            buffAccount wAccountLen 第三方自己的帐号字符
            dwSdkAppid  unsigned int/4  sdkappid
            dwAuthId    unsigned int/4  群组号码
            dwExpTime   unsigned int/4  过期时间 （当前时间 + 有效期（单位：秒，建议300秒））
            dwPrivilegeMap  unsigned int/4  权限位
            dwAccountType   unsigned int/4  第三方帐号类型
        */
        $userBuf = pack('C1', '0'); //cVer  unsigned char/1 版本号，填0
        $userBuf .= pack('n', strlen($userId)); //wAccountLen   unsigned short /2   第三方自己的帐号长度
        $userBuf .= pack('a'.strlen($userId), $userId); //buffAccount   wAccountLen 第三方自己的帐号字符
        $userBuf .= pack('N', $this->sdkAppId); //dwSdkAppid    unsigned int/4  sdkappid
        $userBuf .= pack('N', $roomId); //dwAuthId  unsigned int/4  群组号码/音视频房间号
        $userBuf .= pack('N', time() + $expire); //dwExpTime unsigned int/4  过期时间 （当前时间 + 有效期（单位：秒，建议300秒））
        $userBuf .= pack('N', hexdec("0xff")); //dwPrivilegeMap unsigned int/4  权限位
        $userBuf .= pack('N', 0); //dwAccountType  unsigned int/4  第三方帐号类型

        return $this->getTlsSign()->sign($userId, $expire, $userBuf);
    }
}
