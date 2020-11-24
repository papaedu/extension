<?php

namespace Papaedu\Extension\Filesystem;

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
     * @var string
     */
    protected $domain = '';

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
        $path = $path ? $path : $default;
        if (!$path) {
            return '';
        }

        if (preg_match('/^http[s]?:\/\//', $path)) {
            return $path;
        }

        return $this->getDisk()->url($path);
    }

    /**
     * 去除地址的域名
     *
     * @param  string  $url
     * @return string|void
     */
    public function parseUrl(string $url)
    {
        if (parse_url($url, PHP_URL_HOST) == $this->domain) {
            return ltrim(parse_url($url, PHP_URL_PATH), '/');
        }

        return $url;
    }

    /**
     * 上传
     *
     * @param  \Illuminate\Http\UploadedFile|string  $file
     * @param  string  $ext
     * @param  string|null  $prefix
     * @return string
     */
    public function put($file, string $ext = '', ?string $prefix = null)
    {
        $path = is_string($file) ? $this->getKey($ext, $prefix) : $this->getPathPrefix($prefix);

        $result = $this->getDisk()->put($path, $file);

        return is_string($file) ? $path : $result;
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
     * 删除
     *
     * @param  string  $path
     * @return bool
     */
    public function delete(string $path)
    {
        return $this->getDisk()->delete($this->parseUrl($path));
    }

    /**
     * 获取随机文件名
     *
     * @param  string  $ext
     * @param  string|null  $prefix
     * @return string
     */
    public function getKey(string $ext, ?string $prefix = null)
    {
        $key = $this->getPathPrefix($prefix).'/'.$this->getFilename($ext);
        if ($this->exists($key)) {
            return $this->getKey($ext);
        }

        return $key;
    }

    /**
     * 获取上传Token
     *
     * @param  string  $path
     * @param  string  $mimeLimit
     * @param  integer  $fSizeLimit
     * @return string
     */
    public function getUploadToken(string $path, string $mimeLimit = '', int $fSizeLimit = 0)
    {
        $policy = [];
        if ($mimeLimit) {
            $policy['mimeLimit'] = $mimeLimit;
        }
        if ($fSizeLimit) {
            $policy['fsizeLimit'] = $fSizeLimit;
        }

        return $this->getDisk()->getUploadToken($path, 3600, $policy);
    }

    /**
     * 设置域名
     *
     * @param  string  $domain
     * @return string
     */
    protected function setDomain(string $domain)
    {
        $this->domain = preg_replace('/^http[s]?:\/\//', '', $domain);
    }
}
