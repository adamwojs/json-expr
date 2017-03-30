<?php

namespace AdamWojs\JsonExpr\Tests\Expression\Compare;

use AdamWojs\JsonExpr\Expression\Compare\Gte;
use AdamWojs\JsonExpr\Expression\Id;
use AdamWojs\JsonExpr\Expression\Value;
use AdamWojs\JsonExpr\Tests\Expression\BaseCompareOperatorTest;

class GteTest extends BaseCompareOperatorTest
{
    /**
     * @inheritdoc
     */
    protected function createCompareOperator(Id $id, Value $value)
    {
        return new Gte($id, $value);
    }
}
