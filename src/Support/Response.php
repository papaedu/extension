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
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function errorBadRequest($message = 'Bad Request')
    {
        $this->error($message, HttpResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Return a 401 unauthorized error.
     *
     * @param  string  $message
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        $this->error($message, HttpResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * Return a 403 forbidden error.
     *
     * @param  string  $message
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function errorForbidden($message = 'Forbidden')
    {
        $this->error($message, HttpResponse::HTTP_FORBIDDEN);
    }

    /**
     * Return a 404 not found error.
     *
     * @param  string  $message
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function errorNotFound($message = 'Not Found')
    {
        $this->error($message, HttpResponse::HTTP_NOT_FOUND);
    }

    /**
     * Return a 405 method not allowed error.
     *
     * @param  string  $message
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function errorMethodNotAllowed($message = 'Method Not Allowed')
    {
        $this->error($message, HttpResponse::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * Return a 500 internal server error.
     *
     * @param  string  $message
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function errorInternalServerError($message = 'Internal Server Error')
    {
        $this->error($message, HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
