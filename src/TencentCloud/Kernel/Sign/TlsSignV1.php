<?php

namespace Papaedu\Extension\TencentCloud\Kernel\Sign;

use Papaedu\Extension\TencentCloud\Exceptions\InvalidSignException;
use Papaedu\Extension\TencentCloud\Kernel\Contracts\TlsSignInterface;

/**
 * Class TlsSignV1
 *
 * @package Papaedu\Extension\TencentCloud\Kernel
 */
class TlsSignV1 implements TlsSignInterface
{
    use TlsBase64;
    use TlsSignKey;

    /**
     * @var string
     */
    protected string $sdkAppId;

    /**
     * @var array
     */
    protected array $verifyResult = [];

    /**
     * TlsSignV1 constructor.
     *
     * @param  string  $sdkAppId
     * @param  string  $privateKey
     * @param  string  $publicKey
     */
    public function __construct(string $sdkAppId, string $privateKey, string $publicKey)
    {
        if (!extension_loaded('openssl')) {
            trigger_error('need openssl extension', E_USER_ERROR);
        }
        if (!in_array('sha256', openssl_get_md_methods(), true)) {
            trigger_error('need openssl support sha256', E_USER_ERROR);
        }
        $this->sdkAppId = $sdkAppId;
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
    }

    /**
     * @param  string  $identifier
     * @param  int  $expire
     * @param  string  $userBuf
     * @return string
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidConfigException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidSignException
     */
    public function sign(string $identifier, int $expire = 15552000, string $userBuf = ''): string
    {
        $params = [
            'TLS.account_type' => '0',
            'TLS.identifier' => (string)$identifier,
            'TLS.appid_at_3rd' => '0',
            'TLS.sdk_appid' => (string)$this->sdkAppId,
            'TLS.expire_after' => (string)$expire,
            'TLS.version' => '201512300000',
            'TLS.time' => (string)time(),
        ];
        if ($userBuf) {
            $params['TLS.userbuf'] = base64_encode($userBuf);
        }
        $signString = $this->buildSignString($params, !empty($userBuf));
        $params['TLS.sig'] = $this->makeSign($signString);
        if (false == $params['TLS.sig']) {
            throw new InvalidSignException('base64_encode error');
        }
        $json = json_encode($params);
        if (false == $json) {
            throw new InvalidSignException('json_encode error');
        }
        $compressed = gzcompress($json);
        if (false == $compressed) {
            throw new InvalidSignException('gzcompress error');
        }

        return $this->base64Encode($compressed);
    }

    /**
     * @param  string  $sign
     * @param  string  $identifier
     * @param  bool  $userBufEnabled
     * @return bool
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidConfigException
     */
    public function verify(string $sign, string $identifier, bool $userBufEnabled = false): bool
    {
        try {
            $decodedSign = $this->base64Decode($sign);
            $uncompressedSign = gzuncompress($decodedSign);
            if (false === $uncompressedSign) {
                throw new InvalidSignException('gzuncompress error');
            }
            $params = json_decode($uncompressedSign, true);
            if (false == $params) {
                throw new InvalidSignException('json_decode error');
            }
            if ($params['TLS.identifier'] !== $identifier) {
                throw new InvalidSignException("identifier error sigid:{$params['TLS.identifier']} id:{$identifier}");
            }
            if ($params['TLS.sdk_appid'] != $this->sdkAppId) {
                throw new InvalidSignException("appid error sigappid:{$params['TLS.appid']} thisappid:{$this->sdkAppId}");
            }
            $signString = $this->buildSignString($params, $userBufEnabled);
            $sign = base64_decode($params['TLS.sig']);
            if (false == $sign) {
                throw new InvalidSignException('sig json_decode error');
            }
            $success = $this->makeVerify($signString, $sign);
            if (!$success) {
                throw new InvalidSignException('verify failed');
            }

            $this->verifyResult = [
                'time' => $params['TLS.time'],
                'expire_after' => $params['TLS.expire_after'],
                'userbuf' => base64_decode($params['TLS.userbuf']),
            ];

            return true;
        } catch (InvalidSignException $e) {
            $this->verifyResult = [
                'error_msg' => $e->getMessage(),
            ];

            return false;
        }
    }

    /**
     * @return array
     */
    public function getVerifyResult(): array
    {
        return $this->verifyResult;
    }

    /**
     * @param  string  $data
     * @return string
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidConfigException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidSignException
     */
    protected function makeSign(string $data): string
    {
        $this->setPrivateKey();
        $sign = '';
        if (!openssl_sign($data, $sign, $this->privateKey, 'sha256')) {
            throw new InvalidSignException(openssl_error_string());
        }

        return base64_encode($sign);
    }

    /**
     * @param  array  $params
     * @param  bool  $userBuf
     * @return string
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidSignException
     */
    protected function buildSignString(array $params, bool $userBuf = false): string
    {
        $content = '';
        $aid3rd = 'TLS.appid_at_3rd';
        if (isset($params[$aid3rd])) {
            $content .= "{$aid3rd}:{$params[$aid3rd]}\n";
        }
        $members = [
            'TLS.account_type',
            'TLS.identifier',
            'TLS.sdk_appid',
            'TLS.time',
            'TLS.expire_after',
        ];
        if (!empty($userBuf)) {
            $members[] = 'TLS.userbuf';
        }
        foreach ($members as $member) {
            if (!isset($params[$member])) {
                throw new InvalidSignException('json need '.$member);
            }
            $content .= "{$member}:{$params[$member]}\n";
        }

        return $content;
    }

    /**
     * @param  string  $data
     * @param  string  $sign
     * @return int
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidConfigException
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidSignException
     */
    protected function makeVerify(string $data, string $sign): int
    {
        $this->setPublicKey();
        $ret = openssl_verify($data, $sign, $this->publicKey, 'sha256');
        if ($ret == -1) {
            throw new InvalidSignException(openssl_error_string());
        }

        return $ret;
    }
}
