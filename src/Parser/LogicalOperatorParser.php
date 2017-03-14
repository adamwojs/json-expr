<?php

namespace AdamWojs\FilterBuilder\Parser;

use AdamWojs\FilterBuilder\Expression\LogicalOperator;

class LogicalOperatorParser implements LogicalOperatorParserInterface
{
    /** @var string */
    private $class;

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * @inheritdoc
     */
    public function parse(array $args): LogicalOperator
    {
        return new $this->class(...$args);
    }
}
