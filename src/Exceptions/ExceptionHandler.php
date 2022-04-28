<?php

namespace Papaedu\Extension\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionHandler extends Handler
{
    /**
     * Convert the given exception to an array.
     *
     * @param  \Throwable  $e
     * @return array
     */
    protected function convertExceptionToArray(Throwable $e): array
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
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return response()->json([
            'message' => current(current(array_values($exception->errors()))),
        ], $exception->status);
    }

    /**
     * Prepare exception for rendering.
     *
     * @param  \Throwable  $e
     * @return \Throwable
     */
    protected function prepareException(Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $message = 'No query results for model';
            if (count($e->getIds()) > 0) {
                $message .= ' '.implode(', ', $e->getIds());
            } else {
                $message .= '.';
            }

            $e = new NotFoundHttpException($message, $e);
        } else {
            $e = parent::prepareException($e);
        }

        return $e;
    }
}
