<?php

namespace AdamWojs\JsonExpr\Tests\SymbolTable;

use AdamWojs\JsonExpr\Expression\Id;
use AdamWojs\JsonExpr\Expression\Value;
use AdamWojs\JsonExpr\Parser\SymbolTable\SymbolTable;
use PHPUnit\Framework\TestCase;

class SymbolTableTest extends TestCase
{
    /** @var SymbolTable */
    private $symbolTable;

    protected function setUp()
    {
        $this->symbolTable = new SymbolTable([
            'foo', 'bar', 'baz'
        ]);
    }

    public function testGetReference()
    {
        $result = $this->symbolTable->getReference('foo');

        $this->assertInstanceOf(Id::class, $result);
        $this->assertEquals('foo', $result->getId());
    }

    public function testGetReferenceFailure()
    {
        $this->assertNull($this->symbolTable->getReference('foobaz'));
    }

    public function testGetValue()
    {
        $value = $this->symbolTable->getValue('foo', 'ABC');

        $this->assertInstanceOf(Value::class, $value);
        $this->assertEquals('ABC', $value->getValue());
    }
}
