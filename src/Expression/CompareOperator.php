<?php

namespace AdamWojs\JsonExpr\Expression;

abstract class CompareOperator implements ExpressionInterface
{
    /** @var Id */
    protected $id;

    /** @var Value */
    protected $value;

    /**
     * CompareOperator constructor.
     *
     * @param Id $id
     * @param Value $value
     */
    public function __construct(Id $id, Value $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getValue(): Value
    {
        return $this->value;
    }

    /**
     * @inheritdoc
     */
    public function accept(NodeVisitorInterface $visitor)
    {
        return $visitor->visitCompareOperator($this);
    }
}
