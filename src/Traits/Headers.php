<?php

namespace Papaedu\Extension\Traits;

use Illuminate\Http\Request;

trait Headers
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $headerKeys
     * @return array
     */
    protected function getHeaders(Request $request, array $headerKeys): array
    {
        if (! $headerKeys) {
            return [];
        }

        $headers = [];
        foreach ($headerKeys as $headerKey) {
            $headers[$headerKey] = $request->header($headerKey);
        }

        return $headers;
    }
}
