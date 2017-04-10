<?php

namespace AdamWojs\JsonExpr\Expression;

abstract class LogicalOperator implements ExpressionInterface
{
    /** @var ExpressionInterface[] */
    protected $args;

    public function __construct(ExpressionInterface ...$args)
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
