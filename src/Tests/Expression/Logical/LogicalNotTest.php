<?php

namespace AdamWojs\JsonExpr\Tests\Expression\Logical;

use AdamWojs\JsonExpr\Expression\Logical\LogicalNot;
use AdamWojs\JsonExpr\Tests\Expression\BaseLogicalOperatorTest;

class LogicalNotTest extends BaseLogicalOperatorTest
{
    /**
     * @inheritdoc
     */
    protected function createLogicalOperator(array $args)
    {
        return new LogicalNot(...$args);
    }
}
