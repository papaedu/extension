<?php

namespace Papaedu\Extension\TencentCloud\Kernel\Sign;

use Papaedu\Extension\TencentCloud\Exceptions\InvalidSignException;
use Papaedu\Extension\TencentCloud\Kernel\Contracts\TlsSignInterface;

/**
 * Class TlsSignV2
 *
 * @package Papaedu\Extension\TencentCloud\Kernel
 */
class TlsSignV2 implements TlsSignInterface
{
    use TlsBase64;

    /**
     * @var string
     */
    protected string $sdkAppId;

    /**
     * @var string
     */
    protected string $key;

    /**
     * @var array
     */
    protected array $verifyResult = [];

    public function __construct(string $sdkAppId, string $key)
    {
        $this->sdkAppId = $sdkAppId;
        $this->key = $key;
    }

    /**
     * @param  string  $identifier
     * @param  int  $expire
     * @param  string  $userBuf
     * @return string
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidSignException
     */
    public function sign(string $identifier, int $expire = 15552000, string $userBuf = ''): string
    {
        $curTime = time();
        $params = [
            'TLS.ver' => '2.0',
            'TLS.identifier' => (string)$identifier,
            'TLS.sdkappid' => (string)$this->sdkAppId,
            'TLS.expire' => (string)$expire,
            'TLS.time' => (string)$curTime,
        ];
        $base64UserBuf = '';
        if (!empty($userBuf)) {
            $base64UserBuf = base64_encode($userBuf);
            $params['TLS.userbuf'] = $base64UserBuf;
        }

        $params['TLS.sig'] = $this->hmacsha256($identifier, $curTime, $expire, $base64UserBuf);
        if (false == $params['TLS.sig']) {
            throw new InvalidSignException('base64_encode error');
        }
        $json = json_encode($params);
        if (false === $json) {
            throw new InvalidSignException('json_encode error');
        }
        $compressed = gzcompress($json);
        if (false === $compressed) {
            throw new InvalidSignException('gzcompress error');
        }

        return $this->base64Encode($compressed);
    }

    /**
     * @param  string  $sign
     * @param  string  $identifier
     * @param  bool  $userBufEnabled
     * @return bool
     */
    public function verify(string $sign, string $identifier, bool $userBufEnabled = false): bool
    {
        try {
            $uncompressedSign = $this->base64Decode($sign);
            if (false == $uncompressedSign) {
                throw new InvalidSignException('gzuncompress error');
            }
            $params = json_decode($uncompressedSign, true);
            if (false == $params) {
                throw new InvalidSignException('json_decode error');
            }
            if ($params['TLS.identifier'] !== $identifier) {
                throw new InvalidSignException("identifier dosen't match");
            }
            if ($params['TLS.sdkappid'] != $this->sdkAppId) {
                throw new InvalidSignException("sdkappid dosen't match");
            }
            $sign = $params['TLS.sig'];
            if (false == $sign) {
                throw new InvalidSignException('sig field is missing');
            }
            $curTime = time();
            if ($curTime > intval($params['TLS.time'] + $params['TLS.expire'])) {
                throw new InvalidSignException('sig expired');
            }

            $this->verifyResult = [
                'time' => $params['TLS.time'],
                'expire' => $params['TLS.expire'],
            ];

            $base64UserBuf = '';
            if (isset($params['TLS.userbuf'])) {
                $base64UserBuf = $params['TLS.userbuf'];
                $this->verifyResult['userbuf'] = base64_decode($base64UserBuf);
            }
            $sigCalculated = $this->hmacsha256($identifier, $params['TLS.time'], $params['TLS.expire'], $base64UserBuf);
            if ($sign != $sigCalculated) {
                throw new InvalidSignException('verify failed');
            }

            return true;
        } catch (InvalidSignException $e) {
            $this->verifyResult = [
                'error_msg' => $e->getMessage(),
            ];

            return false;
        }
    }

    /**
     * @param  string  $identifier
     * @param  int  $currTime
     * @param  int  $expire
     * @param  string  $base64UserBuf
     * @return string
     */
    protected function hmacsha256(string $identifier, int $currTime, int $expire, string $base64UserBuf)
    {
        $contentToBeSigned = "TLS.identifier:{$identifier}\nTLS.sdkappid:{$this->sdkAppId}\nTLS.time:{$currTime}\nTLS.expire:{$expire}\n";
        if (!empty($base64UserBuf)) {
            $contentToBeSigned .= "TLS.userbuf:{$base64UserBuf}\n";
        }

        return base64_encode(hash_hmac('sha256', $contentToBeSigned, $this->key, true));
    }
}
