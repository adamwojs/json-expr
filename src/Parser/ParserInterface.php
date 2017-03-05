<?php

namespace AdamWojs\FilterBuilder\Parser;

use AdamWojs\FilterBuilder\Expression\NodeInterface;

interface ParserInterface
{
    public function parse(array $node): NodeInterface;
}
