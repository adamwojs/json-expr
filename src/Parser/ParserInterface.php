<?php

namespace AdamWojs\JsonExpr\Parser;

use AdamWojs\JsonExpr\Expression\NodeInterface;

interface ParserInterface
{
    public function parse(array $node): NodeInterface;
}
