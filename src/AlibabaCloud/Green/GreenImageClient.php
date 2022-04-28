<?php

namespace Papaedu\Extension\AlibabaCloud\Green;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Result\Result;
use AlibabaCloud\Green\Green;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\AlibabaCloud\Green\Enums\GreenScanResult;
use Papaedu\Extension\Models\MediaLibrary;

class GreenImageClient
{
    use GreenTrait;

    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param  string  $url
     * @param  array  $scenes
     * @param  string  $callback
     * @return \Papaedu\Extension\AlibabaCloud\Green\Enums\GreenScanResult
     */
    public function asyncScan(string $url, array $scenes = [], string $callback = ''): GreenScanResult
    {
        try {
            $result = Green::v20180509()
                ->imageAsyncScan()
                ->jsonBody([
                    'biz_type' => $this->config['biz_type'],
                    'scenes' => $scenes ?: $this->config['scenes']['image'],
                    'tasks' => ['url' => $url],
                    'callback' => url($callback ?: $this->config['callback']),
                    'seed' => $this->config['seed'],
                ])
                ->request();

            return $this->getScanResult($result);
        } catch (ClientException $e) {
            Log::error('Alibaba_GreenImageClient[asyncScan]', [
                'message' => $e->getMessage(),
                'error_code' => $e->getErrorCode(),
                'error_message' => $e->getErrorMessage(),
            ]);
        } catch (ServerException $e) {
            Log::error('Alibaba_GreenImageClient[asyncScan]', [
                'message' => $e->getMessage(),
                'error_code' => $e->getErrorCode(),
                'request_id' => $e->getRequestId(),
                'error_message' => $e->getErrorMessage(),
            ]);
        }

        return GreenScanResult::REVIEW;
    }

    protected function getScanResult(Result $result): GreenScanResult
    {
        if (! $result->isSuccess()) {
            Log::error('Alibaba_GreenImageClient[getScanResult] request error.', $result->toArray());

            return GreenScanResult::REVIEW;
        }

        $data = Arr::first($result['data']);
        if ($data['code'] != 200 || ! isset($data['taskId'])) {
            Log::warning('Alibaba_GreenImageClient[getScanResult] data code error.', $data);

            return GreenScanResult::REVIEW;
        }

        $this->taskId = $data['taskId'];

        return GreenScanResult::CHECKING;
    }

    public function callback(Request $request)
    {
        if (! $this->checkSum($request->input('checksum'), $request->input('content'))) {
            Log::warning('GreenImageClient[callback] checksum failed.');

            return null;
        }

        $data = json_decode($request->input('content'), true);
        // 通过 taskId 获取 MediaLibrary 实例
        $mediaLibrary = MediaLibrary::getScanTaskIdInfo($data['taskId']);
        if (empty($mediaLibrary)) {
            return null;
        }

        if ($data['code'] == 200) {
            $results = Arr::pluck($data['results'], 'suggestion');
            if (in_array('block', $results)) {
                $scanResult = GreenScanResult::BLOCK;
            } elseif (in_array('review', $results)) {
                $scanResult = GreenScanResult::REVIEW;
            } else {
                $scanResult = GreenScanResult::PASS;
            }
        } else {
            $scanResult = GreenScanResult::REVIEW;
        }

        $mediaLibrary->scan_result = $scanResult->value;
        $mediaLibrary->save();

        MediaLibrary::deleteScanTaskId($data['taskId']);

        return $mediaLibrary;
    }

    /**
     * @param  string  $checkSum
     * @param  string  $content
     * @return bool
     */
    protected function checkSum(string $checkSum, string $content): bool
    {
        return $checkSum == hash('SHA256', $this->config['uid'].$this->config['seed'].$content);
    }
}
