<?php

namespace AdamWojs\JsonExpr\Compiler;

use AdamWojs\JsonExpr\Expression\NodeInterface;

interface NodeVisitorInterface
{
    public function visit(CompilerInterface $compiler, NodeInterface $expr);
}
