<?php

namespace AdamWojs\FilterBuilder\Parser;

use AdamWojs\FilterBuilder\Expression\Id;
use AdamWojs\FilterBuilder\Expression\NodeInterface;
use AdamWojs\FilterBuilder\Expression\Value;

class GenericParser implements ParserInterface
{
    /** @var array */
    private $compareOperators;
    /** @var array */
    private $logicalOperators;
    /** @var string */
    private $defaultCompareOperator;

    public function __construct(array $logicalOperators, array $compareOperators, string $defaultCompareOperator = null)
    {
        $this->logicalOperators = $logicalOperators;
        $this->compareOperators = $compareOperators;
        $this->defaultCompareOperator = $defaultCompareOperator;
    }

    /**
     * @inheritdoc
     */
    public function parse(array $node): NodeInterface
    {
        return $this->parseExpression($node);
    }

    protected function parseExpression(array $node)
    {
        try {
            return $this->parseLogicalOperator($node);
        } catch (\Exception $ex) {
            return $this->parseComparision($node);
        }
    }

    protected function parseLogicalOperator($node)
    {
        $op = key($node);

        if ($this->isLogicalOperator($op)) {
            return $this->logicalOperators[$op]->parse(array_map(function ($node) {
                return $this->parseExpression($node);
            }, $node[$op]));
        }

        throw new ParserException("Undefined logical operator: $op");
    }

    protected function parseComparision($node)
    {
        $id = key($node);

        return $this->parseComparisionOperator($this->parseId($id), $node[$id]);
    }

    protected function parseComparisionOperator(Id $id, $value)
    {
        if (!is_array($value)) {
            // Use default comparision operator
            return $this
                ->compareOperators[$this->defaultCompareOperator]
                ->parse($id, $this->parseValue($value));
        }

        $op = key($value);
        if ($this->isCmpOperator($op)) {
            return $this->compareOperators[$op]->parse($id, $this->parseValue($value[$op]));
        }

        throw new ParserException("Undefined comparision operator: $op");
    }

    protected function parseValue($node)
    {
        return new Value($node);
    }

    protected function parseId($id)
    {
        if (!is_string($id)) {
            throw new ParserException("Invalid id value: $id");
        }

        return new Id($id);
    }

    protected function isLogicalOperator($value): bool
    {
        return isset($this->logicalOperators[$value]);
    }

    protected function isCmpOperator($value): bool
    {
        return isset($this->compareOperators[$value]);
    }
}
