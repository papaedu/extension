<?php

namespace Papaedu\Extension\Validation\Rules\Filesystem;

use Illuminate\Contracts\Validation\Rule;
use Papaedu\Extension\Filesystem\Disk;

class ImageExistsOfQiniu implements Rule
{
    public function passes($attribute, $value): bool
    {
        return Disk::qiniu()->image()->exists($value);
    }

    public function message(): string
    {
        return ':attribute 不存在或上传失败';
    }
}
