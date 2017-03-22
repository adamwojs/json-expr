<?php

namespace AdamWojs\FilterBuilder\Parser;

use AdamWojs\FilterBuilder\Expression\NodeInterface;
use AdamWojs\FilterBuilder\Parser\Exception\ParserException;
use AdamWojs\FilterBuilder\Parser\SymbolTable\SymbolTableInterface;

class Parser implements ParserInterface
{
    const COMPARE_EXPR = 0;
    const LOGICAL_EXPR = 1;

    /** @var CompareOperatorFactory */
    private $compareOperatorFactory;
    /** @var LogicalOperatorFactory */
    private $logicalOperatorsFactory;
    /** @var SymbolTableInterface */
    private $symbolTable;

    public function __construct(CompareOperatorFactory $compareOperators,
                                LogicalOperatorFactory $logicalOperators,
                                SymbolTableInterface $symbolTable)
    {
        $this->compareOperatorFactory = $compareOperators;
        $this->logicalOperatorsFactory = $logicalOperators;
        $this->symbolTable = $symbolTable;
    }

    public function parse(array $node): NodeInterface
    {
        return $this->expr($node);
    }

    protected function expr(array $node): NodeInterface
    {
        switch ($this->resolveExpressionType($node)) {
            case self::LOGICAL_EXPR:
                return $this->logicalExpr($node);
            case self::COMPARE_EXPR:
                return $this->compareExpr($node);
            default:
                throw new ParserException("Undefined expression type.");
        }
    }

    protected function logicalExpr(array $node): NodeInterface
    {
        $name = key($node);
        $args = array_map(function ($child) {
            return $this->expr($child);
        }, current($node));

        return $this->logicalOperatorsFactory->factory($name, $args);
    }

    protected function compareExpr(array $node): NodeInterface
    {
        $id = key($node);

        list(
            $operator,
            $value
        ) = $this->resolveCompareOperator($id, $node);

        return $this->createCompareOperator($operator, $id, $value);
    }

    protected function createCompareOperator(string $operator, string $id, $value): NodeInterface
    {
        if (!$this->compareOperatorFactory->supports($operator)) {
            throw new ParserException("Undefined comparison operator: $operator.");
        }

        $ref = $this->symbolTable->getReference($id);
        if (!$ref) {
            throw new ParserException("Undefined id reference: $id");
        }

        $val = $this->symbolTable->getValue($id, $value);

        return $this->compareOperatorFactory->factory($operator, $ref, $val);
    }

    protected function resolveCompareOperator(string $id, array $node): array
    {
        $op = null;
        $val = null;

        // The comparison operator is given directly ?
        if (is_array($node[$id])) {
            $op = key($node[$id]);
            $val = current($node[$id]);
        } else {
            $op = $this->compareOperatorFactory->getDefault();
            $val = $node[$id];
        }

        return [$op, $val];
    }

    protected function resolveExpressionType(array $node)
    {
        $name = key($node);
        if ($this->logicalOperatorsFactory->supports($name)) {
            return self::LOGICAL_EXPR;
        }

        return self::COMPARE_EXPR;
    }
}
