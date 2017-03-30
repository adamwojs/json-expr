<?php

namespace AdamWojs\JsonExpr\Tests\Expression;

use AdamWojs\JsonExpr\Expression\Value;
use PHPUnit\Framework\TestCase;

class ValueTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertEquals('foo', (new Value('foo'))->getValue());
    }
}
