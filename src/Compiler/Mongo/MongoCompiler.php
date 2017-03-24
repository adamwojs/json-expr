<?php

namespace AdamWojs\JsonExpr\Compiler\Mongo;

use AdamWojs\JsonExpr\Compiler\CompilerInterface;
use AdamWojs\JsonExpr\Compiler\NodeVisitorInterface;
use AdamWojs\JsonExpr\Expression\NodeInterface;

class MongoCompiler implements CompilerInterface
{
    /** @var array NodeVisitor[] */
    private $visitors = [];

    public function register($class, NodeVisitorInterface $visitor)
    {
        $this->visitors[$class] = $visitor;
    }

    /**
     * @inheritdoc
     */
    public function compile(NodeInterface $expr)
    {
        $visitor = $this->visitors[get_class($expr)];
        if ($visitor instanceof NodeVisitorInterface) {
            return $visitor->visit($this, $expr);
        }

        throw new \InvalidArgumentException("Unsupported expression class: ".get_class($expr));
    }
}
