<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImRemoveTagRequest extends TimRequest
{
    public function __construct(string $toAccount, array $tags)
    {
        $this->setToAccount($toAccount)
            ->setTags($tags);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/all_member_push/im_remove_tag';
    }

    /**
     * @param  string  $toAccount
     * @return $this
     */
    public function setToAccount(string $toAccount): self
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }

    /**
     * @param  array  $tags
     * @return $this
     */
    public function setTags(array $tags): self
    {
        $this->setParameter('Tags', $tags);

        return $this;
    }
}
