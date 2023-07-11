<?php

namespace Papaedu\Extension\Filesystem\Aliyun;

use Carbon\Carbon;
use Papaedu\Extension\Facades\AlibabaCloud;
use Papaedu\Extension\Filesystem\Core\AdapterAbstract;
use Papaedu\Extension\Filesystem\Disk;

abstract class AliyunAdapterAbstract extends AdapterAbstract
{
    public function getUploadToken(string $bucket): array
    {
        $paths = [
            Disk::aliyun()->image()->generateDir(),
            Disk::aliyun()->image()->generateDir(needYmd: false).Carbon::tomorrow()->format('Y/m/d/'),
        ];

        $assumeRole = AlibabaCloud::sts()->oss()->assumeRole($bucket, self::TOKEN_EXPIRED, $paths);

        return [
            'security_token' => $assumeRole['Credentials']['SecurityToken'],
            'access_key_id' => $assumeRole['Credentials']['AccessKeyId'],
            'access_key_secret' => $assumeRole['Credentials']['AccessKeySecret'],
            'expiration' => $assumeRole['Credentials']['Expiration'],
        ];
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
