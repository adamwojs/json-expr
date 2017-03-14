<?php

namespace AdamWojs\FilterBuilder\Parser;

use AdamWojs\FilterBuilder\Expression\LogicalOperator;

interface LogicalOperatorParserInterface
{
    public function parse(array $args) : LogicalOperator;
}
