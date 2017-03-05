<?php

namespace AdamWojs\FilterBuilder\Expression\Logical;

use AdamWojs\FilterBuilder\Expression\NodeInterface;

class LogicalNot implements NodeInterface
{
    /** @var NodeInterface */
    private $expression;

    public function __construct(NodeInterface $expression)
    {
        $this->expression = $expression;
    }

    public function getExpression(): NodeInterface
    {
        return $this->expression;
    }
}
