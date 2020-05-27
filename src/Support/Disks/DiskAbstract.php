<?php

namespace Papaedu\Extension\Support\Disks;

use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

abstract class DiskAbstract
{
    use DiskTrait;

    /**
     * @var string
     */
    protected $diskName = '';

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem|\Illuminate\Filesystem\FilesystemAdapter
     */
    public function getDisk()
    {
        if (!$this->diskName) {
            throw new InvalidArgumentException('Disk Name is empty.');
        }

        return Storage::disk($this->diskName);
    }

    /**
     * 获取完整地址
     *
     * @param  string  $path
     * @param  string  $default
     * @return string
     */
    public function url(string $path, string $default = '')
    {
        $path = $path ?: $default;
        if (!$path) {
            return '';
        }

        if (preg_match('/http[s]:\/\//', $path)) {
            return $path;
        }

        return $this->getDisk()->url(['path' => $path, 'domainType' => 'https']);
    }

    /**
     * 去除地址的域名
     *
     * @param  string  $url
     * @return string|void
     */
    public function parseUrl(string $url)
    {
        if (parse_url($url, PHP_URL_HOST) == $this->getDomain()) {
            return ltrim(parse_url($url, PHP_URL_PATH), '/');
        }

        return $url;
    }

    /**
     * 上传
     *
     * @param  string  $module
     * @param  \Illuminate\Http\UploadedFile|string  $file
     * @return string
     */
    public function put(string $module, $file)
    {
        return $this->getDisk()->put($this->getPathPrefix($module), $file);
    }

    /**
     * 是否存在
     *
     * @param  string  $path
     * @return bool
     */
    public function exists(string $path)
    {
        return $this->getDisk()->exists($path);
    }

    /**
     * 获取随机文件名
     *
     * @param  string  $module
     * @param  string  $ext
     * @return string
     */
    public function getKey(string $module, string $ext)
    {
        return $this->getPathPrefix($module) . $this->getFilename($ext);
    }

    /**
     * 获取上传Token
     *
     * @return string
     */
    public function getUploadToken(string $path, string $mimeLimit = '')
    {
        $policy = $mimeLimit ? ['mineLimit' => $mimeLimit] : [];

        return $this->getDisk()->getDriver()->uploadToken($path, 3600, $policy);
    }

    /**
     * 返回域名
     */
    protected function getDomain()
    {
        return '';
    }
}
