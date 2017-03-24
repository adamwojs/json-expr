<?php

namespace AdamWojs\JsonExpr\Compiler;

use AdamWojs\JsonExpr\Expression\NodeInterface;

interface CompilerInterface
{
    public function compile(NodeInterface $expr);
}
