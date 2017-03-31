<?php

namespace AdamWojs\JsonExpr\Compiler\Mongo;

use AdamWojs\JsonExpr\Compiler\CompilerInterface;
use AdamWojs\JsonExpr\Compiler\NodeVisitorInterface;
use AdamWojs\JsonExpr\Expression\Compare\Eq;
use AdamWojs\JsonExpr\Expression\Compare\Lt;
use AdamWojs\JsonExpr\Expression\NodeInterface;
use AdamWojs\JsonExpr\Expression\Id;
use AdamWojs\JsonExpr\Expression\Logical\LogicalAnd;
use AdamWojs\JsonExpr\Expression\Value;

class MongoCompilerBuilder
{
    public function build(): MongoCompiler
    {
        $compiler = new MongoCompiler();

        $compiler->register(Eq::class, new class implements NodeVisitorInterface {
            public function visit(CompilerInterface $compiler, NodeInterface $expr)
            {
                return [$compiler->compile($expr->getId()) => [
                    '$eq' => $compiler->compile($expr->getValue())
                ]];
            }
        });

        $compiler->register(Lt::class, new class implements NodeVisitorInterface {
            public function visit(CompilerInterface $compiler, NodeInterface $expr)
            {
                return [$compiler->compile($expr->getId()) => [
                    '$lt' => $compiler->compile($expr->getValue())
                ]];
            }
        });

        $compiler->register(LogicalAnd::class, new class implements NodeVisitorInterface {
            public function visit(CompilerInterface $compiler, NodeInterface $expr)
            {
                return [
                    '$and' => array_map(function ($expr) use ($compiler) {
                        return $compiler->compile($expr);
                    }, $expr->getArgs())
                ];
            }
        });

        $compiler->register(Id::class, new class implements NodeVisitorInterface {
            public function visit(CompilerInterface $compiler, NodeInterface $expr)
            {
                return $expr->getId();
            }
        });

        $compiler->register(Value::class, new class implements NodeVisitorInterface {
            public function visit(CompilerInterface $compiler, NodeInterface $expr)
            {
                return $expr->getValue();
            }
        });

        return $compiler;
    }
}
