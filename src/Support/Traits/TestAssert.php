<?php

namespace Papaedu\Extension\Support\Traits;

use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;

trait TestAssert
{
    /**
     * Assert json structure for paginate list.
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
     * Assert json structure for list.
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
     * Assert json structure for view.
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
     * Assert bad request message.
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
     * Assert bad request message and code.
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
