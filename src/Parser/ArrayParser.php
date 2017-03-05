<?php

namespace AdamWojs\FilterBuilder\Parser;

use AdamWojs\FilterBuilder\Expression\Cmp\Eq;
use AdamWojs\FilterBuilder\Expression\Cmp\Lt;
use AdamWojs\FilterBuilder\Expression\Id;
use AdamWojs\FilterBuilder\Expression\Logical\LogicalAnd;
use AdamWojs\FilterBuilder\Expression\NodeInterface;
use AdamWojs\FilterBuilder\Expression\Value;

class ArrayParser implements ParserInterface
{
    /** @var array */
    private $infix = [];
    /** @var array */
    private $prefix = [];

    public function __construct()
    {
        $this->prefix['$and'] = function (array $args) {
            return new LogicalAnd(...$args);
        };

        $this->infix['$eq'] = function (Id $id, $value) {
            return new Eq($id, new Value($value['$eq']));
        };

        $this->infix['$lt'] = function (Id $id, $value) {
            return new Lt($id, new Value($value['$lt']));
        };
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
            return $this->prefix[$op](array_map(function ($token) {
                return $this->expr($token);
            }, $token[$op]));
        }

        throw new \Exception("Unknow logical operator: $op");
    }

    public function cmp($token)
    {
        $id = key($token);

        return $this->cmp_operator($this->id($id), $token[$id]);
    }

    public function cmp_operator(Id $id, $value)
    {
        if (!is_array($value)) {
            return $this->infix['$eq']($id, $value);
        }

        $op = key($value);

        if (!$this->isCmpOperator($op)) {
            throw new \Exception("Unknow comperision operator $op");
        }

        return $this->infix[$op]($id, $value);
    }

    public function value($token)
    {
        return new Value($token);
    }

    public function id($token)
    {
        if (!is_string($token)) {
            throw new \InvalidArgumentException("Invalid token: ID expected");
        }

        return new Id($token);
    }

    private function isLogicalOperator($value): bool
    {
        return isset($this->prefix[$value]);
    }

    private function isCmpOperator($value): bool
    {
        return isset($this->infix[$value]);
    }
}
