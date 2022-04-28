<?php

namespace Papaedu\Extension\AlibabaCloud\Green;

use AlibabaCloud\Client\Result\Result;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

trait GreenTrait
{
    protected string $taskId;

    /**
     * @param  \AlibabaCloud\Client\Result\Result  $result
     * @return bool
     */
    protected function checkResult(Result $result): bool
    {
        if (!$result->isSuccess()) {
            Log::error('Alibaba_GreenClient[getScanResult] request error.', $result->toArray());

            return false;
        }

        $data = Arr::first($result['data']);
        if ($data['code'] != 200 || !isset($data['taskId'])) {
            Log::warning('Alibaba_GreenClient[getScanResult] data code error.', $data);

            return false;
        }

        $this->taskId = $data['taskId'];

        return true;
    }

    public function getTaskId(): string
    {
        return $this->taskId;
    }
}
