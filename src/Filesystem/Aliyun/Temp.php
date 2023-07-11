<?php

namespace Papaedu\Extension\Filesystem\Aliyun;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * @deprecated
 */
class Temp
{
    public function verify(Request $request): bool
    {
        if (! $request->server('HTTP_AUTHORIZATION') || ! $request->server('HTTP_X_OSS_PUB_KEY_URL')) {
            return false;
        }

        $authorization = base64_decode($request->server('HTTP_AUTHORIZATION'));
        $publicKeyUrl = base64_decode($request->server('HTTP_X_OSS_PUB_KEY_URL'));
        $publicKey = Http::get($publicKeyUrl);
        if (! $publicKey) {
            return false;
        }
        $body = $request->getContent();

        $path = $request->server('REQUEST_URI');
        $pos = strpos($path, '?');

        if ($pos === false) {
            $authStr = urldecode($path)."\n".$body;
        } else {
            $authStr = urldecode(substr($path, 0, $pos)).substr($path, $pos, strlen($path) - $pos)."\n".$body;
        }

        return openssl_verify($authStr, $authorization, $publicKey, OPENSSL_ALGO_MD5) == 1;
    }

    public function getSignatureConfig(string $ext = '', ?int $size = null, string $mineType = '', ?int $height = null, ?int $width = null): string
    {
        $dir = $this->getDir();
        $filename = $this->getFilename($ext);
        if ($this->exists($dir.$filename)) {
            return $this->getSignatureConfig($ext, $size, $mineType, $height, $width);
        }

        if ($this->diskType == 'oss') {
            $customData = array_filter([
                'filename' => $filename,
                'size' => $size,
                'mimeType' => $mineType,
                'height' => $height,
                'width' => $width,
            ]);

            return $this->getDisk()->signatureConfig($dir, '', $customData, 300);
        } else {
            $policy = [];
            if ($mineType) {
                $policy['mimeLimit'] = $mineType;
            }
            if ($size) {
                $policy['fsizeLimit'] = $size;
            }

            return $this->getDisk()->getUploadToken($dir.$filename, 300, $policy);
        }
    }
}
