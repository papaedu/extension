<?php

namespace Papaedu\Extension\MediaLibrary;

use Papaedu\Extension\AlibabaCloud\Green\Enums\GreenScanResult;
use Papaedu\Extension\Enums\MediaType;
use Papaedu\Extension\Facades\AlibabaCloud;
use Papaedu\Extension\Models\MediaLibrary as MediaLibraryModel;

class Image extends MediaLibraryAbstract
{
    protected MediaType $type = MediaType::IMAGE;

    protected function validateGreen(string $path, MediaLibraryModel $mediaLibrary): GreenScanResult
    {
        $greenImage = AlibabaCloud::green()->image();
        $result = $greenImage->asyncScan($path);

        MediaLibraryModel::setScanTaskId($greenImage->getTaskId(), $mediaLibrary->id);

        return $result;
    }
}
