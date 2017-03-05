<?php

namespace AdamWojs\FilterBuilder\Compiler;

use AdamWojs\FilterBuilder\Expression\NodeInterface;

interface NodeVisitorInterface
{
    public function visit(CompilerInterface $compiler, NodeInterface $expr);
}
