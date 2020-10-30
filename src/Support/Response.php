<?php

namespace Papaedu\Extension\Support;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Response
{
    /**
     * Respond a array response.
     *
     * @param  array  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function array(array $data)
    {
        return response()->json(['data' => $data]);
    }

    /**
     * Response a object response.
     *
     * @param  \Illuminate\Support\Collection  $collection
     * @return \Illuminate\Http\JsonResponse
     */
    public function collection(Collection $collection)
    {
        return response()->json(['data' => $collection->toArray()]);
    }

    /**
     * Response a string response.
     *
     * @param  string  $string
     * @return \Illuminate\Http\JsonResponse
     */
    public function string(string $string)
    {
        return response()->json($string);
    }

    /**
     * Response a JSONP response.
     *
     * @param  string  $callback
     * @param  array  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonp(string $callback, array $data)
    {
        return response()->jsonp($callback, ['data' => $data]);
    }

    /**
     * Respond with a created response and associate a location if provided.
     *
     * @param  array  $content
     * @return \Illuminate\Http\JsonResponse
     */
    public function created(array $content = [])
    {
        return response()->json($content ? ['data' => $content] : [], HttpResponse::HTTP_CREATED);
    }

    /**
     * Respond with an accepted response and associate a location and/or content if provided.
     *
     * @param  array  $content
     * @return \Illuminate\Http\JsonResponse
     */
    public function accepted(array $content = [])
    {
        return response()->json($content ? ['data' => $content] : [], HttpResponse::HTTP_ACCEPTED);
    }

    /**
     * Respond with a no content response.
     *
     * @return \Illuminate\Http\Response
     */
    public function noContent()
    {
        return response()->noContent();
    }

    /**
     * Return an error response.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function error($message, $statusCode)
    {
        throw new HttpException($statusCode, $message);
    }

    /**
     * Return a 400 bad request error.
     *
     * @param  string  $message
     * @param  int|null  $code
     */
    public function errorBadRequest($message = 'Bad Request', ?int $code = 0)
    {
        throw new HttpException(HttpResponse::HTTP_BAD_REQUEST, $message, null, [], $code);
    }

    /**
     * Return a 401 unauthorized error.
     *
     * @param  string  $message
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        throw new HttpException(HttpResponse::HTTP_UNAUTHORIZED, $message);
    }

    /**
     * Return a 403 forbidden error.
     *
     * @param  string  $message
     */
    public function errorForbidden($message = 'Forbidden')
    {
        throw new HttpException(HttpResponse::HTTP_FORBIDDEN, $message);
    }

    /**
     * Return a 404 not found error.
     *
     * @param  string  $message
     */
    public function errorNotFound($message = 'Not Found')
    {
        throw new HttpException(HttpResponse::HTTP_NOT_FOUND, $message);
    }

    /**
     * Return a 405 method not allowed error.
     *
     * @param  string  $message
     */
    public function errorMethodNotAllowed($message = 'Method Not Allowed')
    {
        throw new HttpException(HttpResponse::HTTP_METHOD_NOT_ALLOWED, $message);
    }

    /**
     * Return a 500 internal server error.
     *
     * @param  string  $message
     */
    public function errorInternalServerError($message = 'Internal Server Error')
    {
        throw new HttpException(HttpResponse::HTTP_INTERNAL_SERVER_ERROR, $message);
    }
}
