<?php

namespace AdamWojs\FilterBuilder\Parser;

use AdamWojs\FilterBuilder\Expression\CompareOperator;

interface CompareOperatorParserInterface
{
    public function parse($id, $value) : CompareOperator;
}
