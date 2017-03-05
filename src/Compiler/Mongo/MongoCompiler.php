<?php

namespace AdamWojs\FilterBuilder\Compiler\Mongo;

use AdamWojs\FilterBuilder\Compiler\CompilerInterface;
use AdamWojs\FilterBuilder\Compiler\NodeVisitorInterface;
use AdamWojs\FilterBuilder\Expression\NodeInterface;

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
