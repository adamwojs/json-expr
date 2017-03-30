<?php

namespace AdamWojs\JsonExpr\Tests\Mock;

use AdamWojs\JsonExpr\Expression\NodeInterface;

class NodeMock implements NodeInterface
{
    private $type;
    private $args;

    public function __construct(string $type = '', array $args = null)
    {
        $this->type = $type;
        $this->args = $args;
    }
}
