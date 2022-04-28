<?php

namespace Papaedu\Extension\Filesystem;

use Overtrue\Flysystem\Qiniu\QiniuAdapter as BaseQiniuAdapter;

class QiniuAdapter extends BaseQiniuAdapter
{
    public function getUploadTokenFixed(string $key = null, int $expires = 3600, array $policy = null, bool $strictPolice = true): string
    {
        return $this->getAuthManager()->uploadToken($this->bucket, $key, $expires, $policy, $strictPolice);
    }
}
