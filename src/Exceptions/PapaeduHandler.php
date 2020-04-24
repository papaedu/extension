<?php

namespace Papaedu\Extension\Exceptions;

use Illuminate\Validation\ValidationException;
use Throwable;

trait PapaeduHandler
{
    /**
     * Convert the given exception to an array.
     *
     * @param  \Throwable  $e
     * @return array
     */
    protected function convertExceptionToArray(Throwable $e)
    {
        $data = parent::convertExceptionToArray($e);
        if ($e->getCode()) {
            $data['code'] = $e->getCode();
        }

        return $data;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'message' => current(current(array_values($exception->errors()))),
        ], $exception->status);
    }
}
