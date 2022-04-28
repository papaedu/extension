<?php

namespace Papaedu\Extension\AlibabaCloud\Green;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Result\Result;
use AlibabaCloud\Green\Green;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\AlibabaCloud\Green\Enums\GreenScanResult;

class GreenTextClient
{
    use GreenTrait;

    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param  string  $content
     * @return \Papaedu\Extension\AlibabaCloud\Green\Enums\GreenScanResult
     */
    public function scan(string $content): GreenScanResult
    {
        try {
            $result = Green::v20180509()
                ->textScan()
                ->jsonBody([
                    'scenes' => ['antispam'],
                    'tasks' => ['content' => $content],
                ])
                ->request();

            return $this->getScanResult($result);
        } catch (ClientException $e) {
            Log::error('AliYunGreenText[scan]', [
                'message' => $e->getMessage(),
            ]);
        } catch (ServerException $e) {
            Log::error('AliYunGreenText[scan]', [
                'message' => $e->getMessage(),
                'error_code' => $e->getErrorCode(),
                'request_id' => $e->getRequestId(),
                'error_message' => $e->getErrorMessage(),
            ]);
        }

        return GreenScanResult::REVIEW;
    }

    /**
     * @param  \AlibabaCloud\Client\Result\Result  $result
     * @return \Papaedu\Extension\AlibabaCloud\Green\Enums\GreenScanResult
     */
    protected function getScanResult(Result $result): GreenScanResult
    {
        if (!$result->isSuccess()) {
            Log::error('Alibaba_GreenTextClient[getScanResult] request error.', $result->toArray());

            return GreenScanResult::REVIEW;
        }

        $data = Arr::first($result['data']);
        if ($data['code'] != 200 || !isset($data['taskId'])) {
            Log::warning('Alibaba_GreenTextClient[getScanResult] data code error.', $data);

            return GreenScanResult::REVIEW;
        }

        $this->taskId = $data['taskId'];

        $data = Arr::first($result['data']);
        $results = Arr::pluck($data['results'], 'suggestion');
        if (in_array(GreenScanResult::BLOCK, $results)) {
            return GreenScanResult::BLOCK;
        } elseif (in_array(GreenScanResult::REVIEW, $results)) {
            return GreenScanResult::REVIEW;
        }

        return GreenScanResult::PASS;
    }
}
