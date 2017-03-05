<?php

namespace AdamWojs\FilterBuilder\Compiler\Mongo;

use AdamWojs\FilterBuilder\Compiler\CompilerInterface;
use AdamWojs\FilterBuilder\Compiler\NodeVisitorInterface;
use AdamWojs\FilterBuilder\Expression\Cmp\Eq;
use AdamWojs\FilterBuilder\Expression\Cmp\Lt;
use AdamWojs\FilterBuilder\Expression\NodeInterface;
use AdamWojs\FilterBuilder\Expression\Id;
use AdamWojs\FilterBuilder\Expression\Logical\LogicalAnd;
use AdamWojs\FilterBuilder\Expression\Value;

class MongoCompilerBuilder
{
    public function build(): MongoCompiler
    {
        $compiler = new MongoCompiler();

        $compiler->register(Eq::class, new class implements NodeVisitorInterface
        {
            public function visit(CompilerInterface $compiler, NodeInterface $expr)
            {
                return [$compiler->compile($expr->getFirst()) => [
                    '$eq' => $compiler->compile($expr->getSecond())
                ]];
            }
        });

        $compiler->register(LogicalAnd::class, new class implements NodeVisitorInterface
        {
            public function visit(CompilerInterface $compiler, NodeInterface $expr)
            {
                return [
                    '$and' => array_map(function($expr) use($compiler) {
                        return $compiler->compile($expr);
                    }, $expr->getArgs())
                ];
            }
        });

        $compiler->register(Lt::class, new class implements NodeVisitorInterface
        {
            public function visit(CompilerInterface $compiler, NodeInterface $expr)
            {
                return [$compiler->compile($expr->getFirst()) => [
                    '$lt' => $compiler->compile($expr->getSecond())
                ]];
            }
        });

        $compiler->register(Id::class, new class implements NodeVisitorInterface
        {
            public function visit(CompilerInterface $compiler, NodeInterface $expr)
            {
                return $expr->getId();
            }
        });

        $compiler->register(Value::class, new class implements NodeVisitorInterface
        {
            public function visit(CompilerInterface $compiler, NodeInterface $expr)
            {
                return $expr->getValue();
            }
        });

        return $compiler;
    }
}
