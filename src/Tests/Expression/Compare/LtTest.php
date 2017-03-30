<?php

namespace AdamWojs\JsonExpr\Tests\Expression\Compare;

use AdamWojs\JsonExpr\Expression\Compare\Lt;
use AdamWojs\JsonExpr\Expression\Id;
use AdamWojs\JsonExpr\Expression\Value;
use AdamWojs\JsonExpr\Tests\Expression\BaseCompareOperatorTest;

class LtTest extends BaseCompareOperatorTest
{
    /**
     * @inheritdoc
     */
    protected function createCompareOperator(Id $id, Value $value)
    {
        return new Lt($id, $value);
    }
}
