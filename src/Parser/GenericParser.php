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
        return $this->expr($node);
    }

    public function expr(array $node)
    {
        try {
            return $this->logical_operator($node);
        } catch (\Exception $ex) {
            return $this->cmp($node);
        }
    }

    public function logical_operator($token)
    {
        $op = key($token);

        if ($this->isLogicalOperator($op)) {
            return $this->logicalOperators[$op]->parse(array_map(function ($token) {
                return $this->expr($token);
            }, $token[$op]));
        }

        throw new ParserException("Unknow logical operator: $op");
    }

    public function cmp($token)
    {
        $id = key($token);

        return $this->cmp_operator($this->id($id), $token[$id]);
    }

    public function cmp_operator(Id $id, $value)
    {
        $op = $this->defaultCompareOperator;
        if (is_array($value)) {
            $op = key($value);
        }

        if (!$this->isCmpOperator($op)) {
            throw new ParserException("Unknow comperision operator: $op");
        }

        return $this->compareOperators[$op]->parse($id, $this->value($value[$op]));
    }

    public function value($token)
    {
        return new Value($token);
    }

    public function id($token)
    {
        if (!is_string($token)) {
            throw new ParserException("Invalid token: ID expected");
        }

        return new Id($token);
    }

    private function isLogicalOperator($value): bool
    {
        return isset($this->logicalOperators[$value]);
    }

    private function isCmpOperator($value): bool
    {
        return isset($this->compareOperators[$value]);
    }
}
