<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\ImOpenLoginSvc\Parameters;

use Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException;
use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class AccountItem extends Parameter
{
    /**
     * AccountItem constructor.
     *
     * @param  array|string  $userId
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidArgumentException
     */
    public function __construct($userId)
    {
        if (is_array($userId)) {
            $this->setUserIds($userId);
        } elseif (is_string($userId)) {
            $this->setUserId($userId);
        }

        throw new InvalidArgumentException('$userId must be array or string.');
    }

    /**
     * @param  string  $userId
     */
    public function setUserId(string $userId)
    {
        $this->parameters[] = [
            'UserID' => $userId,
        ];
    }

    /**
     * @param  array  $userIds
     */
    public function setUserIds(array $userIds)
    {
        foreach ($userIds as $userId) {
            $this->setUserId($userId);
        }
    }
}
