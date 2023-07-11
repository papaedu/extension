<?php

namespace Papaedu\Extension\Filesystem\Traits;

use getID3;

trait DurationTrait
{
    public function getDuration(string $url): int
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
