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
}
