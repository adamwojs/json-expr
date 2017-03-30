<?php

namespace AdamWojs\JsonExpr\Tests\Expression;

use AdamWojs\JsonExpr\Expression\CompareOperator;
use AdamWojs\JsonExpr\Expression\Id;
use AdamWojs\JsonExpr\Expression\Value;
use PHPUnit\Framework\TestCase;

abstract class BaseCompareOperatorTest extends TestCase
{
    public function testConstruct()
    {
        $ref = $this->createMock(Id::class);
        $val = $this->createMock(Value::class);

        $operator = $this->createCompareOperator($ref, $val);

        $this->assertEquals($ref, $operator->getId());
        $this->assertEquals($val, $operator->getValue());
    }

    /**
     * Create operator instance.
     *
     * @param Id $id
     * @param Value $value
     *
     * @return CompareOperator
     */
    protected abstract function createCompareOperator(Id $id, Value $value);
}
