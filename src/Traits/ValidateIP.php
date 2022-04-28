<?php

namespace Papaedu\Extension\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use IPTools\IP;
use IPTools\Range;

trait ValidateIP
{
    protected array $ips = [];

    protected function inIps(?string $targetIp): bool
    {
        if (empty($targetIp)) {
            return false;
        }

        try {
            $targetIp = new IP($targetIp);
            foreach ($this->ips as $ip) {
                if (Range::parse($ip)->contains($targetIp)) {
                    return true;
                }
            }

            return false;
        } catch (Exception $e) {
            Log::warning('ValidateIP ', [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
