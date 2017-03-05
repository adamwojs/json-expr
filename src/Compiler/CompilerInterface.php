<?php

namespace AdamWojs\FilterBuilder\Compiler;

use AdamWojs\FilterBuilder\Expression\NodeInterface;

interface CompilerInterface
{
    public function compile(NodeInterface $expr);
}
