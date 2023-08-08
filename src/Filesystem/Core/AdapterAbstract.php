<?php

namespace Papaedu\Extension\Filesystem\Core;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

abstract class AdapterAbstract
{
    protected string $domain = '';

    protected Filesystem $disk;

    public const TMP_DIR = 'tmp/';

    private const TEST_DIR = 'test/';

    protected const TOKEN_EXPIRED = 900;

    public function __construct(protected string $diskName = '', string $domain = '')
    {
        $this->domain = preg_replace('~^(http|https)://~ixu', '', $domain);
    }

    public function getDisk(): Filesystem
    {
        if (! $this->diskName) {
            throw new InvalidArgumentException('Disk Name is empty.');
        }
        if (! isset($this->disk)) {
            $this->disk = Storage::disk($this->diskName);
        }

        return $this->disk;
    }

    public function url(string $path): string
    {
        if (! $path) {
            return '';
        }

        if (preg_match('~^(http|https)://~ixu', $path)) {
            return $path;
        }

        return $this->getDisk()->url($path);
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

        $result = $this->getDisk()->put($path, $file);

        return is_string($file) ? $path : $result;
    }

    /**
     * @deprecated
     */
    public function simplePut(string $path, string $content, string $ext = '', bool $isTmp = false): string
    {
        $path = $this->generateDir($path, $isTmp, false).$this->generateFilename($ext);
        $this->getDisk()->put($path, $content);

        return $path;
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

        $result = $this->getDisk()->move($from, $to);

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

        $this->getDisk()->copy($from, $to);

        return $to;
    }

    public function exists(string $path): bool
    {
        $path = $this->path($path);
        if (! $path) {
            return false;
        }

        return $this->getDisk()->exists($path);
    }

    public function size(string $path): int
    {
        $path = $this->path($path);
        if (! $path) {
            return 0;
        }

        return $this->getDisk()->size($path);
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

        return $this->getDisk()->delete($path);
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

    public function generatePaths(int $number, string $ext, string $prefix, bool $isTmp = true): array
    {
        if (! $ext) {
            return [];
        }

        $paths = [];
        for ($i = 0; $i < $number; $i++) {
            $paths[] = $this->generatePath($ext, $prefix, $isTmp);
        }

        return $paths;
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
