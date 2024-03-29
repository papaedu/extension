<?php

namespace Papaedu\Extension\Filesystem\Tencent;

use Illuminate\Support\Str;
use Qcloud\Cos\Client as TencentCosClient;

abstract class TencentAdapterAbstract
{
    protected string $domain;

    protected TencentCosClient $client;

    public const TMP_DIR = 'tmp/';

    private const TEST_DIR = 'test/';

    public function __construct(protected string $bucket, protected string $region, string $domain)
    {
        $this->domain = preg_replace('~^(http|https)://~ixu', '', rtrim($domain, '/'));
    }

    abstract public function getClient(): TencentCosClient;

    public function url(string $path): string
    {
        if (! $path) {
            return '';
        }

        if (preg_match('~^(http|https)://~ixu', $path)) {
            return $path;
        }

        return 'https://'.$this->domain.'/'.ltrim($path, '/');
    }

    public function getSignedUrl(string $path): string
    {
        $path = $this->path($path);
        if (! $path) {
            return '';
        }

        return $this->getClient()->getObjectUrl($this->bucket, $path);
    }

    public function path(string $url): string
    {
        if (! $url) {
            return '';
        }

        return preg_replace('~^(http|https)://[^/]+/~ixu', '', $url);
    }

    public function put($file, string $ext = '', string $prefix = '', bool $isTmp = false): string
    {
        $path = is_string($file) ? $this->generatePath($ext, $prefix, $isTmp) : $this->generateDir($prefix);

        $result = $this->getClient()->upload($this->bucket, $path, $file);

        return is_string($file) ? $path : $result;
    }

    public function move(string $from, string $to = ''): string
    {
        $from = $this->path($from);
        if (! $from) {
            return '';
        }

        $ext = pathinfo($from, PATHINFO_EXTENSION);
        if (! $ext) {
            return '';
        }

        if (! $to) {
            if (str_starts_with($from, self::TMP_DIR)) {
                $to = substr($from, 4);
            } else {
                $to = $this->generatePath($ext, isTmp: false);
            }
        }

        $this->copy($from, $to);
        $result = $this->delete($from);

        if ($result) {
            return $to;
        } else {
            return '';
        }
    }

    public function copy(string $from, string $to = ''): string
    {
        $from = $this->path($from);
        if (! $from) {
            return '';
        }

        $ext = pathinfo($from, PATHINFO_EXTENSION);
        if (! $ext) {
            return '';
        }

        if ($to) {
            $to = $this->path($to);
        }
        // !! 不能和上面的 if 合并
        if (! $to) {
            $to = $this->generatePath($ext, isTmp: false);
        }

        $this->getClient()->copy($this->bucket, $to, [
            'Bucket' => $this->bucket,
            'Region' => $this->region,
            'Key' => $from,
        ]);

        return $to;
    }

    public function exists(string $path): bool
    {
        $path = $this->path($path);
        if (! $path) {
            return false;
        }

        return $this->getClient()->doesObjectExist($this->bucket, $path);
    }

    public function size(string $path): int
    {
        $path = $this->path($path);
        if (! $path) {
            return 0;
        }

        $result = $this->getClient()->HeadObject([
            'Bucket' => $this->bucket,
            'Key' => $path,
        ]);

        return $result['ContentLength'];
    }

    public function delete(string $path): bool
    {
        $path = $this->path($path);
        if (! $path) {
            return false;
        }
        $path = trim($path, '/');

        if (Str::startsWith($path, config('extension.filesystem.delete_blocklist', []))) {
            return true;
        }

        if (! app()->environment('production')) {
            return true;
        }

        try {
            $this->getClient()->DeleteObject([
                'Bucket' => $this->bucket,
                'Key' => $path,
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getPutPreSignedUrl(string $ext, ?string $expires = '+10 minutes'): string
    {
        return $this->getClient()->getPresignedUrl('putObject', [
            'Bucket' => $this->bucket,
            'Key' => $this->getKey($ext),
            'Body' => '',
        ], $expires);
    }

    public function getKey(string $ext, string $prefix = ''): string
    {
        return $this->generatePath($ext, $prefix);
    }

    public function generatePath(string $ext, string $prefix = '', bool $isTmp = true): string
    {
        if (! $ext) {
            return '';
        }

        $key = $this->generateDir($prefix, $isTmp).$this->generateFilename($ext);
        if ($this->exists($key)) {
            return $this->generatePath($ext);
        }

        return $key;
    }

    public function generateDir(string $prefix = '', bool $isTmp = false, bool $needYmd = true): string
    {
        $dir = $isTmp ? self::TMP_DIR : '';
        $dir .= app()->environment('production') ? '' : self::TEST_DIR;
        $dir .= $prefix ? trim($prefix, '/').'/' : '';
        $dir .= $needYmd ? date('Y/m/d/') : '';

        return $dir;
    }

    protected function generateFilename(string $ext): string
    {
        $filename = Str::random(40);

        return "{$filename}.{$ext}";
    }
}
