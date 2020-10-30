<?php

namespace Papaedu\Extension\Traits;

use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;

trait TestTrait
{
    /**
     * 断言带分页的列表结构
     *
     * @param  \Illuminate\Testing\TestResponse  $response
     * @param  array  $data
     */
    protected function assertJsonStructurePaginate(TestResponse $response, array $data)
    {
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    $data,
                ],
                'meta' => [
                    'current_page',
                    'last_page',
                    'total',
                ],
            ]);
    }

    /**
     * 断言列表结构
     *
     * @param  \Illuminate\Testing\TestResponse  $response
     * @param  array  $data
     */
    protected function assertJsonStructure(TestResponse $response, array $data)
    {
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    $data,
                ],
            ]);
    }

    /**
     * 断言详情结构
     *
     * @param  \Illuminate\Testing\TestResponse  $response
     * @param  array  $data
     */
    protected function assertJsonStructureView(TestResponse $response, array $data)
    {
        $response->assertOk()
            ->assertJsonStructure([
                'data' => $data,
            ]);
    }

    /**
     * 断言错误请求返回信息
     *
     * @param  \Illuminate\Testing\TestResponse  $response
     * @param  string  $message
     */
    protected function assertJsonBadRequestMessage(TestResponse $response, string $message)
    {
        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonFragment(['message' => $message]);
    }

    /**
     * 断言错误请求返回信息和Code
     *
     * @param  \Illuminate\Testing\TestResponse  $response
     * @param  string  $message
     * @param  int  $code
     */
    protected function assertJsonBadRequestMessageAndCode(TestResponse $response, string $message, int $code)
    {
        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonFragment([
                'message' => $message,
                'code' => $code,
            ]);
    }
}
