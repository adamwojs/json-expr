<?php

namespace AdamWojs\FilterBuilder\Parser;

class GenericParserBuilder
{
    /** @var array */
    private $logicalOperators;
    /** @var array */
    private $compareOperator;
    /** @var string */
    private $defaultCompareOperator;
    /** @var SymbolTableInterface */
    private $symbolTable;

    /**
     * GenericParserBuilder constructor.
     */
    public function __construct()
    {
        $this->logicalOperators = [];
        $this->compareOperator = [];
    }

    public function addCompareOperator(string $id, CompareOperatorParserInterface $operator)
    {
        $this->compareOperator[$id] = $operator;
        return $this;
    }

    public function addLogicalOperator(string $id, LogicalOperatorParserInterface $operator)
    {
        $this->logicalOperators[$id] = $operator;
        return $this;
    }

    public function setDefaultCompareOperator(string $defaultCompareOperator)
    {
        $this->defaultCompareOperator = $defaultCompareOperator;
        return $this;
    }

    public function setSymbolTable(SymbolTableInterface $symbolTable)
    {
        $this->symbolTable = $symbolTable;
        return $this;
    }

    public function build(): ParserInterface
    {
        return new GenericParser(
            $this->logicalOperators,
            $this->compareOperator,
            $this->defaultCompareOperator,
            $this->symbolTable
        );
    }
}
