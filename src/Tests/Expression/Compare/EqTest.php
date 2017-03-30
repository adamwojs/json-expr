<?php

namespace AdamWojs\JsonExpr\Tests\Expression\Compare;

use AdamWojs\JsonExpr\Expression\Compare\Eq;
use AdamWojs\JsonExpr\Expression\Id;
use AdamWojs\JsonExpr\Expression\Value;
use AdamWojs\JsonExpr\Tests\Expression\BaseCompareOperatorTest;

class EqTest extends BaseCompareOperatorTest
{
    /**
     * @inheritdoc
     */
    protected function createCompareOperator(Id $id, Value $value)
    {
        return new Eq($id, $value);
    }
}
