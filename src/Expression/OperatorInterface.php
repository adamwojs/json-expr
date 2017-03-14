<?php

namespace AdamWojs\FilterBuilder\Expression;

interface OperatorInterface extends NodeInterface
{
    const TYPE_PREFIX = 0;
    const TYPE_INFIX = 1;
    const TYPE_POSTFIX = 2;

    public function getType() : int;
}
