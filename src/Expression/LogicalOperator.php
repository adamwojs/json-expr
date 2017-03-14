<?php

namespace AdamWojs\FilterBuilder\Expression;

abstract class LogicalOperator implements OperatorInterface
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
    public function getType(): int
    {
        return OperatorInterface::TYPE_PREFIX;
    }
}
