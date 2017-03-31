<?php

namespace AdamWojs\JsonExpr\Expression;

abstract class LogicalOperator implements NodeInterface
{
    /** @var NodeInterface[] */
    protected $args;

    public function __construct(NodeInterface ...$args)
    {
        if (empty($args)) {
            throw new \InvalidArgumentException("Minimum 1 argument required.");
        }

        $this->args = $args;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @inheritdoc
     */
    public function accept(NodeVisitorInterface $visitor)
    {
        return $visitor->visitLogicalOperator($this);
    }
}
