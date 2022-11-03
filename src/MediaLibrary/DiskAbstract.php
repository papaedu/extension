<?php

namespace Papaedu\Extension\MediaLibrary;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Papaedu\Extension\Enums\MediaType;

abstract class DiskAbstract
{
    protected string $diskType;

    protected string $diskName;

    protected ?Filesystem $disk = null;

    protected MediaType $type;

    public function __construct(string $diskName)
    {
        $this->diskName = $diskName;
    }

    public function getDisk(): Filesystem
    {
        if (! $this->diskName) {
            throw new InvalidArgumentException('Disk name is empty.');
        }

        if (is_null($this->disk)) {
            $this->disk = Storage::disk("oss-{$this->diskName}");
        }

        return $this->disk;
    }

    public function verify(Request $request): bool
    {
        if (! $request->server('HTTP_AUTHORIZATION') || ! $request->server('HTTP_X_OSS_PUB_KEY_URL')) {
            return false;
        }

        $authorization = base64_decode($request->server('HTTP_AUTHORIZATION'));
        $publicKeyUrl = base64_decode($request->server('HTTP_X_OSS_PUB_KEY_URL'));
        $publicKey = Http::get($publicKeyUrl);
        if (! $publicKey) {
            return false;
        }
        $body = $request->getContent();

        $path = $request->server('REQUEST_URI');
        $pos = strpos($path, '?');

        if ($pos === false) {
            $authStr = urldecode($path)."\n".$body;
        } else {
            $authStr = urldecode(substr($path, 0, $pos)).substr($path, $pos, strlen($path) - $pos)."\n".$body;
        }

        return openssl_verify($authStr, $authorization, $publicKey, OPENSSL_ALGO_MD5) == 1;
    }

    public function generatePaths(string $ext, int $number): array
    {
        $data = [];
        for ($index = 0; $index < $number; $index++) {
            $data[] = $this->generatePath($ext);
        }

        return $data;
    }

    public function generatePath(string $ext): string
    {
        $path = $this->getDir().$this->getFilename($ext);
        if ($this->exists($path)) {
            return $this->generatePath($ext);
        }

        return $path;
    }

    public function url(string $path, string $default = ''): string
    {
        $path = $path ?: $default;
        if (! $path) {
            return '';
        }

        if (preg_match('/^https?:\/\//', $path)) {
            return $path;
        }

        return $this->getDisk()->url($path);
    }

    public function parseUrl(string $url): string
    {
        if (parse_url($url, PHP_URL_HOST) == $this->getDisk()->url('')) {
            return ltrim(parse_url($url, PHP_URL_PATH), '/');
        }

        return $url;
    }

    public function getSignatureConfig(string $ext = '', ?int $size = null, string $mineType = '', ?int $height = null, ?int $width = null): string
    {
        $dir = $this->getDir();
        $filename = $this->getFilename($ext);
        if ($this->exists($dir.$filename)) {
            return $this->getSignatureConfig($ext, $size, $mineType, $height, $width);
        }

        if ($this->diskType == 'oss') {
            $customData = array_filter([
                'filename' => $filename,
                'size' => $size,
                'mimeType' => $mineType,
                'height' => $height,
                'width' => $width,
            ]);

            return $this->getDisk()->signatureConfig($dir, '', $customData, 300);
        } else {
            $policy = [];
            if ($mineType) {
                $policy['mimeLimit'] = $mineType;
            }
            if ($size) {
                $policy['fsizeLimit'] = $size;
            }

            return $this->getDisk()->getUploadToken($dir.$filename, 300, $policy);
        }
    }

    public function put($file, string $ext = ''): string
    {
        $path = is_string($file) ? $this->generatePath($ext) : $this->getDir();

        $result = $this->getDisk()->put($path, $file);

        return is_string($file) ? $path : $result;
    }

    public function copy(string $path, string $newPath = ''): string
    {
        if (! $path) {
            return '';
        }

        if (! $newPath) {
            $newPath = $this->generatePath(pathinfo($path, PATHINFO_EXTENSION));
        }
        $this->getDisk()->copy($this->parseUrl($path), $newPath);

        return $newPath;
    }

    public function exists(string $path): bool
    {
        return $this->getDisk()->exists($path);
    }

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

    public function forceDelete(string $path): bool
    {
    }

    public function getPreDir(): string
    {
        return app()->environment('production') ? '' : 'test/';
    }

    public function getDir(): string
    {
        return $this->getPreDir().date('Y/m/d/');
    }

    public function getFilename(string $ext): string
    {
        $filename = Str::random(40);

        return "{$filename}.$ext";
    }
}
