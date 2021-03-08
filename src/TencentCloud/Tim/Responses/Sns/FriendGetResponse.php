<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\Sns;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class FriendGetResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getUserDataItem(): array
    {
        return $this->content['UserDataItem'];
    }

    /**
     * @return int
     */
    public function getStandardSequence(): int
    {
        return $this->content['StandardSequence'];
    }

    /**
     * @return int
     */
    public function getCustomSequence(): int
    {
        return $this->content['CustomSequence'];
    }

    /**
     * @return int
     */
    public function getFriendNum(): int
    {
        return $this->content['FriendNum'];
    }

    /**
     * @return int
     */
    public function getCompleteFlag(): int
    {
        return $this->content['CompleteFlag'];
    }

    /**
     * @return int
     */
    public function getNextStartIndex(): int
    {
        return $this->content['NextStartIndex'];
    }

    /**
     * @return string
     */
    public function getErrorDisplay(): string
    {
        return $this->content['ErrorDisplay'];
    }
}
