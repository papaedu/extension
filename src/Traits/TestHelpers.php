<?php

namespace Papaedu\Extension\Traits;

use Illuminate\Testing\TestResponse;

trait TestHelpers
{
    protected $paginateData = [
        'meta' => [
            'current_page',
            'last_page',
            'total',
        ],
    ];

    /**
     * 断言带分页的列表结构
     *
     * @param  \Illuminate\Testing\TestResponse  $response
     * @param  array  $data
     */
    protected function assertJsonStructurePaginate(TestResponse $response, array $data)
    {
        $response->assertJsonStructure([
            'data' => [
                $data,
            ],
        ]);
        $response->assertJsonStructure($this->paginateData);
    }

    /**
     * 断言列表结构
     *
     * @param  \Illuminate\Testing\TestResponse  $response
     * @param  array  $data
     */
    protected function assertJsonStructure(TestResponse $response, array $data)
    {
        $response->assertJsonStructure([
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
        $response->assertJsonStructure([
            'data' => $data,
        ]);
    }
}