<?php

namespace AdamWojs\FilterBuilder\Parser;

use AdamWojs\FilterBuilder\Expression\CompareOperator;

class CompareOperatorParser implements CompareOperatorParserInterface
{
    private $class;

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * @inheritdoc
     */
    public function parse($id, $value): CompareOperator
    {
        return new $this->class($id, $value);
    }
}
