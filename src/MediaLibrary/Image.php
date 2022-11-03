<?php

namespace Papaedu\Extension\MediaLibrary;

use Papaedu\Extension\Enums\MediaType;

class Image extends DiskAbstract
{
    protected MediaType $type = MediaType::IMAGE;
}
