<?php

namespace Papaedu\Extension\MediaLibrary;

use Papaedu\Extension\Enums\MediaType;

class File extends DiskAbstract
{
    protected MediaType $type = MediaType::FILE;
}
