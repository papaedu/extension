<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class Condition extends Parameter
{
    /**
     * @param  array  $attrsOr
     * @return $this
     */
    public function setAttrsOr(array $attrsOr): self
    {
        $this->setParameter('AttrsOr', $attrsOr);

        return $this;
    }

    /**
     * @param  array  $attrsAnd
     * @return $this
     */
    public function setAttrsAnd(array $attrsAnd): self
    {
        $this->setParameter('AttrsOr', $attrsAnd);

        return $this;
    }

    /**
     * @param  array  $tagsOr
     * @return $this
     */
    public function setTagsOr(array $tagsOr): self
    {
        $this->setParameter('AttrsOr', $tagsOr);

        return $this;
    }

    /**
     * @param  array  $tagsAnd
     * @return $this
     */
    public function setTagsAnd(array $tagsAnd): self
    {
        $this->setParameter('AttrsOr', $tagsAnd);

        return $this;
    }
}
