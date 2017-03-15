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
    /** @var SymbolTable */
    private $symbolTable;

    public function __construct(
        array $logicalOperators,
        array $compareOperators,
        string $defaultCompareOperator = null,
        SymbolTableInterface $symbolTable = null)
    {
        $this->logicalOperators = $logicalOperators;
        $this->compareOperators = $compareOperators;
        $this->defaultCompareOperator = $defaultCompareOperator;
        $this->symbolTable = $symbolTable;
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
        $key = key($node);
        if ($this->isLogicalOperator($key)) {
            return $this->parseLogicalOperator($key, $node);
        }

        return $this->parseComparision($key, $node);
    }

    protected function parseLogicalOperator(string $op, array $node)
    {
        return $this->logicalOperators[$op]->parse(array_map(function ($node) {
            return $this->parseExpression($node);
        }, $node[$op]));
    }

    protected function parseComparision(string $id, array $node)
    {
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

        throw new ParserException("Undefined operator: $op");
    }

    protected function parseValue($node)
    {
        return new Value($node);
    }

    protected function parseId($id)
    {
        if (!is_string($id)) {
            throw new ParserException("Invalid ID: $id");
        }

        if ($this->symbolTable->isAllowedId($id)) {
            return new Id($id);
        }

        throw new ParserException("Undefined ID: $id");
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
