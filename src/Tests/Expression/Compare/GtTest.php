<?php

namespace AdamWojs\JsonExpr\Tests\Expression\Compare;

use AdamWojs\JsonExpr\Expression\Compare\Gt;
use AdamWojs\JsonExpr\Expression\Id;
use AdamWojs\JsonExpr\Expression\Value;
use AdamWojs\JsonExpr\Tests\Expression\BaseCompareOperatorTest;

class GtTest extends BaseCompareOperatorTest
{
    /**
     * @inheritdoc
     */
    protected function createCompareOperator(Id $id, Value $value)
    {
        return new Gt($id, $value);
    }
}
