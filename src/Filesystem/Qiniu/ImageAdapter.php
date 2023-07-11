<?php

namespace Papaedu\Extension\Filesystem\Qiniu;

use Papaedu\Extension\Filesystem\Core\AdapterAbstract;
use Papaedu\Extension\Filesystem\Traits\UrlScaleTrait;

class ImageAdapter extends AdapterAbstract
{
    use UrlScaleTrait;
}
