<?php

namespace Papaedu\Extension\Support;

use BackedEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Response
{
    /**
     * @param  mixed|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function ok(mixed $data = null): JsonResponse
    {
        return new JsonResponse($data);
    }

    /**
     * @param  string  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function json(string $data = ''): JsonResponse
    {
        return new JsonResponse($data, json: true);
    }

    /**
     * Respond a array response.
     *
     * @param  array  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function array(array $data): JsonResponse
    {
        return new JsonResponse(['data' => $data]);
    }

    /**
     * Response a object response.
     *
     * @param  \Illuminate\Support\Collection  $collection
     * @return \Illuminate\Http\JsonResponse
     */
    public function collection(Collection $collection): JsonResponse
    {
        return new JsonResponse(['data' => $collection->toArray()]);
    }

    /**
     * Response a string response.
     *
     * @param  string  $string
     * @return \Illuminate\Http\JsonResponse
     */
    public function string(string $string): JsonResponse
    {
        return new JsonResponse($string);
    }

    /**
     * Response an empty object response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function emptyObject(): JsonResponse
    {
        return new JsonResponse(['data' => null]);
    }

    /**
     * Response a JSONP response.
     *
     * @param  string  $callback
     * @param  array  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonp(string $callback, array $data): JsonResponse
    {
        $jsonResponse = new JsonResponse(['data' => $data]);

        return $jsonResponse->withCallback($callback);
    }

    /**
     * Respond with a created response and associate a location if provided.
     *
     * @param  array  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function created(array $data = []): JsonResponse
    {
        return new JsonResponse($data ? ['data' => $data] : [], 201);
    }

    /**
     * Respond with an accepted response and associate a location and/or content if provided.
     *
     * @param  array  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function accepted(array $data = []): JsonResponse
    {
        return new JsonResponse($data ? ['data' => $data] : [], 202);
    }

    /**
     * Respond with a no content response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function noContent(): JsonResponse
    {
        return new JsonResponse('', 204);
    }

    /**
     * Return an error response.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function error(string $message, int $statusCode)
    {
        throw new HttpException($statusCode, $message);
    }

    /**
     * Return a 400 bad request error.
     *
     * @param  string  $message
     * @param  int|BackedEnum  $code
     */
    public function errorBadRequest(string $message = 'Bad Request', int|BackedEnum $code = 0)
    {
        if ($code instanceof BackedEnum) {
            $code = $code->value;
        }

        throw new HttpException(400, $message, null, [], $code);
    }

    /**
     * Return a 401 unauthorized error.
     *
     * @param  string  $message
     */
    public function errorUnauthorized(string $message = 'Unauthorized')
    {
        throw new HttpException(401, $message);
    }

    /**
     * Return a 403 forbidden error.
     *
     * @param  string  $message
     */
    public function errorForbidden(string $message = 'Forbidden')
    {
        throw new HttpException(403, $message);
    }

    /**
     * Return a 404 not found error.
     *
     * @param  string  $message
     */
    public function errorNotFound(string $message = 'Not Found')
    {
        throw new HttpException(404, $message);
    }

    /**
     * Return a 405 method not allowed error.
     *
     * @param  string  $message
     */
    public function errorMethodNotAllowed(string $message = 'Method Not Allowed')
    {
        throw new HttpException(405, $message);
    }

    /**
     * Return a 500 internal server error.
     *
     * @param  string  $message
     */
    public function errorInternalServerError(string $message = 'Internal Server Error')
    {
        throw new HttpException(500, $message);
    }
}
