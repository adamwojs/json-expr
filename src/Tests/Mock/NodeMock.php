<?php

namespace AdamWojs\JsonExpr\Tests\Mock;

use AdamWojs\JsonExpr\Expression\ExpressionInterface;
use AdamWojs\JsonExpr\Expression\NodeVisitorInterface;

class NodeMock implements ExpressionInterface
{
    private $type;
    private $args;

    public function __construct(string $type = '', array $args = null)
    {
        $this->type = $type;
        $this->args = $args;
    }

    /**
     * @inheritdoc
     */
    public function accept(NodeVisitorInterface $visitor)
    {
        /** Do nothing */
    }
}
