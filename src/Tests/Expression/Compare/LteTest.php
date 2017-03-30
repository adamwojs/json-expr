<?php

namespace AdamWojs\JsonExpr\Tests\Expression\Compare;

use AdamWojs\JsonExpr\Expression\Compare\Lte;
use AdamWojs\JsonExpr\Expression\Id;
use AdamWojs\JsonExpr\Expression\Value;
use AdamWojs\JsonExpr\Tests\Expression\BaseCompareOperatorTest;

class LteTest extends BaseCompareOperatorTest
{
    /**
     * @inheritdoc
     */
    protected function createCompareOperator(Id $id, Value $value)
    {
        return new Lte($id, $value);
    }
}
