<?php

namespace AdamWojs\FilterBuilder\Expression\Logical;

use AdamWojs\FilterBuilder\Expression\NodeInterface;

abstract class LogicalOperator implements NodeInterface
{
    /** @var NodeInterface[] */
    private $args;

    public function __construct(NodeInterface ...$args)
    {
        if (count($args) < 2) {
            throw new \InvalidArgumentException("Minimum 2 arguments required.");
        }

        $this->args = $args;
    }

    public function getArgs(): array
    {
        return $this->args;
    }
}
