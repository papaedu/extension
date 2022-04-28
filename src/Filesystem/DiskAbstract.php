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
    protected string $diskName = '';

    /**
     * @var string
     */
    protected string $domain = '';

    public function __construct(string $diskName, string $domain)
    {
        $this->diskName = $diskName;
        $this->setDomain($domain);
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem|\Illuminate\Filesystem\FilesystemAdapter
     */
    public function getDisk()
    {
        if (! $this->diskName) {
            throw new InvalidArgumentException('Disk Name is empty.');
        }

        return Storage::disk($this->diskName);
    }

    /**
     * Get full url.
     *
     * @param  string  $path
     * @param  string  $default
     * @return string
     */
    public function url(string $path, string $default = ''): string
    {
        $path = $path ? $path : $default;
        if (! $path) {
            return '';
        }

        if (preg_match('/^http[s]?:\/\//', $path)) {
            return $path;
        }

        return $this->getDisk()->url($path);
    }

    /**
     * Parse host for url.
     *
     * @param  string  $url
     * @return string
     */
    public function parseUrl(string $url): string
    {
        if (parse_url($url, PHP_URL_HOST) == $this->domain) {
            return ltrim(parse_url($url, PHP_URL_PATH), '/');
        }

        return $url;
    }

    /**
     * Upload new file.
     *
     * @param  \Illuminate\Http\UploadedFile|string  $file
     * @param  string  $ext
     * @param  string  $prefix
     * @return string
     */
    public function put($file, string $ext = '', string $prefix = ''): string
    {
        $path = is_string($file) ? $this->getKey($ext, $prefix) : $this->getPathPrefix($prefix);

        $result = $this->getDisk()->put($path, $file);

        return is_string($file) ? $path : $result;
    }

    /**
     * Copy file to new path.
     *
     * @param  string  $path
     * @param  string  $newPath
     * @return string
     */
    public function copy(string $path, string $newPath = ''): string
    {
        if (! $path) {
            return '';
        }

        if (! $newPath) {
            $newPath = $this->getKey(pathinfo($path, PATHINFO_EXTENSION));
        }

        $this->getDisk()->copy($this->parseUrl($path), $newPath);

        return $newPath;
    }

    /**
     * @param  string  $path
     * @param  string  $content
     * @param  string  $ext
     * @return string
     */
    public function simplePut(string $path, string $content, string $ext = ''): string
    {
        $path = $this->getPrePathPrefix().trim($path, '/').'/'.$this->getFilename($ext);
        $this->getDisk()->put($path, $content);

        return $path;
    }

    /**
     * Check file exists.
     *
     * @param  string  $path
     * @return bool
     */
    public function exists(string $path): bool
    {
        return $this->getDisk()->exists($path);
    }

    /**
     * Delete file.
     *
     * @param  string  $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        $path = $this->parseUrl($path);
        if (str_contains($path, config('extension.media_library.ban.dir'))) {
            return true;
        }
        if (! app()->environment('production')) {
            return true;
        }

        return $this->getDisk()->delete($path);
    }

    /**
     * 获取随机文件名
     *
     * @param  string  $ext
     * @param  string  $prefix
     * @return string
     */
    public function getKey(string $ext, string $prefix = ''): string
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

        return $this->getDisk()->getAdapter()->getUploadTokenFixed($path, 3600, $policy);
    }

    /**
     * 设置域名
     *
     * @param  string  $domain
     */
    protected function setDomain(string $domain)
    {
        $this->domain = preg_replace('/^http[s]?:\/\//', '', $domain);
    }
}
