<?php

namespace Papaedu\Extension\MediaLibrary;

use getID3;
use Papaedu\Extension\Enums\MediaType;

class Video extends DiskAbstract
{
    protected MediaType $type = MediaType::VIDEO;

    public function getDuration(string $url)
    {
        if ($remote = fopen($this->url($url), 'rb')) {
            $tmp = tempnam('/tmp', 'getID3');
            if ($local = fopen($tmp, 'wb')) {
                while ($buffer = fread($remote, 8192)) {
                    fwrite($local, $buffer);
                }
                fclose($local);
                $getID3 = new getID3();
                $fileInfo = $getID3->analyze($tmp);
                unlink($tmp);
            }
            fclose($remote);

            return round($fileInfo['playtime_seconds'] ?? 0);
        }

        return 0;
    }
}
