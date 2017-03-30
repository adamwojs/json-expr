<?php

namespace AdamWojs\JsonExpr\Tests\Expression;

use AdamWojs\JsonExpr\Expression\Id;
use PHPUnit\Framework\TestCase;

class IdTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertEquals('foo', (new Id('foo'))->getId());
    }
}
