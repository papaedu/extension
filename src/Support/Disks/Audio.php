<?php

namespace Papaedu\Extension\Support\Disks;

use getID3;

class Audio extends DiskAbstract
{
    /**
     * @var string
     */
    protected $diskName = 'qiniu-audio';

    protected function getDomain()
    {
        return config('filesystems.disks.qiniu-audio.domains.https');
    }

    /**
     * @param  string  $url
     * @return false|float|int
     */
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