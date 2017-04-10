<?php

namespace AdamWojs\JsonExpr\Parser;

use AdamWojs\JsonExpr\Expression\ExpressionInterface;

interface ParserInterface
{
    public function parse(array $node): ExpressionInterface;
}
