<?php

namespace Papaedu\Extension\Filesystem\Qiniu;

use Papaedu\Extension\Filesystem\Core\AdapterAbstract;

abstract class QiniuAdapterAbstract extends AdapterAbstract
{
    public function getUploadToken(string $path, string $mimeLimit = '', int $fSizeLimit = 0): string
    {
        $policy = [];
        if ($mimeLimit) {
            $policy['mimeLimit'] = $mimeLimit;
        }
        if ($fSizeLimit) {
            $policy['fsizeLimit'] = $fSizeLimit;
        }

        return $this->getDisk()->getAdapter()->getUploadTokenFixed($path, self::TOKEN_EXPIRED, $policy);
    }
}
