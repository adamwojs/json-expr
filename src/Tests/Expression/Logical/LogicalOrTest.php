<?php

namespace AdamWojs\JsonExpr\Tests\Expression\Logical;

use AdamWojs\JsonExpr\Expression\Logical\LogicalOr;
use AdamWojs\JsonExpr\Tests\Expression\BaseLogicalOperatorTest;

class LogicalOrTest extends BaseLogicalOperatorTest
{
    /**
     * @inheritdoc
     */
    protected function createLogicalOperator(array $args)
    {
        return new LogicalOr(...$args);
    }
}
