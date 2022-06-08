<?php

namespace Papaedu\Extension\MediaLibrary;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Papaedu\Extension\AlibabaCloud\Green\Enums\GreenScanResult;
use Papaedu\Extension\Enums\MediaStatus;
use Papaedu\Extension\Enums\MediaType;
use Papaedu\Extension\Models\MediaLibrary as MediaLibraryModel;

abstract class MediaLibraryAbstract
{
    protected string $diskType;

    protected string $diskName;

    protected string $cdnUrl;

    protected MediaType $type;

    public function __construct(string $diskName)
    {
        $this->diskName = $diskName;
        $this->cdnUrl = config("filesystems.disks.oss-{$diskName}.cdn_url", '');
    }

    public function getDisk(): Filesystem
    {
        if (! $this->diskName) {
            throw new InvalidArgumentException('Disk name is empty.');
        }

        return Storage::disk("{$this->diskType}-{$this->diskName}");
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
        $now = now();
        $data = [];
        for ($index = 0; $index < $number; $index++) {
            $data[] = [
                'type' => $this->type->value,
                'path' => $this->generatePath($ext),
                'status' => MediaStatus::GENERATED,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        MediaLibraryModel::insert($data);

        return Arr::pluck($data, 'path');
    }

    public function generatePath(string $ext): string
    {
        $path = $this->getDir().$this->getFilename($ext);
        if ($this->exists($path)) {
            return $this->generatePath($ext);
        }

        return $path;
    }

    public function setUploaded(string $path, int $height, int $width, int $size, bool $green = false)
    {
        if (! $path || ! $this->exists($path)) {
            return;
        }

        /** @var MediaLibraryModel $mediaLibrary */
        $mediaLibrary = MediaLibraryModel::query()
            ->where('path', $path)
            ->where('status', MediaStatus::GENERATED)
            ->first([
                'id',
            ]);

        if (! $mediaLibrary) {
            return;
        }

        $mediaLibrary->status = MediaStatus::UPLOADED;
        $mediaLibrary->height = $height;
        $mediaLibrary->width = $width;
        $mediaLibrary->size = $size;
        $mediaLibrary->scan_result = $green === true ? $this->validateGreen($this->url($path), $mediaLibrary) : GreenScanResult::REVIEW;
        $mediaLibrary->save();
    }

    public function setUsed(string $path, string $modelType, $builder)
    {
        if (! $this->exists($path)) {
            return null;
        }

        $media = MediaLibraryModel::query()
            ->where('path', $path)
            ->first([
                'id',
                'height',
                'width',
                'model_type',
                'model_id',
                'status',
            ]);
        if ($media) {
            if ($media->scan_result == GreenScanResult::BLOCK->value) {
                $config = config("extension.media_library.ban.{$modelType}", config('extension.media_library.ban.default'));
                $data = [
                    'image_url' => $config['url'],
                    'width' => $config['width'],
                    'height' => $config['height'],
                ];
            } else {
                $data = [
                    'height' => $media->height,
                    'width' => $media->width,
                    'image_url' => $path,
                ];
            }
            $model = $builder->create($data);

            if ($media->status != MediaStatus::USED->value) {
                $media->status = MediaStatus::USED;
            }

            if (! $media->model_id) {
                $media->model_type = $modelType;
                $media->model_id = $model->id;
            }

            $media->save();

            return $model;
        }

        return null;
    }

    protected function validateGreen(string $path, MediaLibraryModel $mediaLibrary): GreenScanResult
    {
        return GreenScanResult::REVIEW;
    }

    public function check(string $path): bool
    {
        if (! $this->exists($path)) {
            return false;
        }
        MediaLibraryModel::query()
            ->where('path', $path)
            ->update([
                'status' => MediaStatus::USED,
            ]);

        return true;
    }

    public function url(string $path, string $default = ''): string
    {
        $path = $path ?: $default;
        if (! $path) {
            return '';
        }

        if (preg_match('/^http[s]?:\/\//', $path)) {
            return $path;
        }

        return rtrim($this->cdnUrl, '/').'/'.ltrim($path, '/');
    }

    public function parseUrl(string $url): string
    {
        if (parse_url($url, PHP_URL_HOST) == $this->cdnUrl) {
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
