<?php

/*
 * This file is part of the papaedu/extension.
 *
 * (c) Pipi Zhang <zhangpipi.o3o@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Extension\QCloud\Tim;

use BiuBiuJun\QCloud\Tim\Requests\Profile\PortraitGetRequest;

class TimPortrait extends TimClient
{
    /**
     * Get user profile.
     *
     * @param  array  $toAccount
     * @param  array  $tagList
     * @return array
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function portraitGet(array $toAccount, array $tagList)
    {
        $request = new PortraitGetRequest($toAccount, $tagList);
        $response = $this->client->sendRequest($request);

        return $response->getUserProfileItem();
    }
}
