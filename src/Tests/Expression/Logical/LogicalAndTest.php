<?php

namespace AdamWojs\JsonExpr\Tests\Expression\Logical;

use AdamWojs\JsonExpr\Expression\Logical\LogicalAnd;
use AdamWojs\JsonExpr\Tests\Expression\BaseLogicalOperatorTest;

class LogicalAndTest extends BaseLogicalOperatorTest
{
    /**
     * @inheritdoc
     */
    protected function createLogicalOperator(array $args)
    {
        return new LogicalAnd(...$args);
    }
}
