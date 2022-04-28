<?php

namespace Papaedu\Extension\TencentCloud\Tiw;

use Closure;
use Illuminate\Http\JsonResponse;
use Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException;
use Papaedu\Extension\TencentCloud\Kernel\Contracts\NotifyInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Notify implements NotifyInterface
{
    protected int $statusCode = Response::HTTP_OK;

    protected array $message = [];

    /**
     * @param  \Closure  $closure
     * @return \Illuminate\Http\JsonResponse
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException
     */
    public function handle(Closure $closure): JsonResponse
    {
        $this->strict(
            \call_user_func($closure, $this->getMessage(), [$this, 'fail'])
        );

        return $this->toResponse();
    }

    public function fail()
    {
        $this->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    public function toResponse(): JsonResponse
    {
        return new JsonResponse(['code' => 0], $this->statusCode);
    }

    public function getMessage()
    {
        if ($this->message) {
            return $this->message;
        }

        $request = Request::createFromGlobals();
        $message = json_decode($request->getContent(), true);

        if (! is_array($message) || empty($message)) {
            throw new InvalidArgumentException('Invalid request JSON.', 400);
        }

        return $this->message = $message;
    }

    protected function strict($result)
    {
        if ($result !== true && empty($this->statusCode)) {
            $this->fail();
        }
    }
}
