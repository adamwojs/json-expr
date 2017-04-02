<?php

namespace AdamWojs\JsonExpr\Tests\Parser;

use AdamWojs\JsonExpr\Parser\Exception\ParserException;
use AdamWojs\JsonExpr\Parser\OperatorProvider\CompareOperatorProviderInterface;
use AdamWojs\JsonExpr\Parser\OperatorProvider\LogicalOperatorProviderInterface;
use AdamWojs\JsonExpr\Parser\Parser;
use AdamWojs\JsonExpr\Parser\SymbolTable\SymbolTableInterface;
use AdamWojs\JsonExpr\Tests\Mock\NodeMock;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParseCompareExpr()
    {
        $parser = new Parser(
            $this->createCompareOperatorProviderMock(['$eq']),
            $this->createLogicalOperatorProviderMock(),
            $this->createSymbolTableMock(['foo'])
        );

        $expected = new NodeMock('cmp', [
            '$eq', [
                new NodeMock('ref', ['foo']),
                new NodeMock('val', ['bar'])
            ]
        ]);

        $this->assertEquals($expected, $parser->parse([
            'foo' => [
                '$eq' => 'bar'
            ]
        ]));
    }

    public function testParseUndefinedExpressionType()
    {
        /** It shouldn't happen */
    }

    public function testParseUndefinedComparisonOperator()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Undefined comparison operator: $gt');

        $parser = new Parser(
            $this->createCompareOperatorProviderMock(['$eq']),
            $this->createLogicalOperatorProviderMock(),
            $this->createSymbolTableMock(['foo'])
        );

        $parser->parse([
            'foo' => [
                '$gt' => 'bar'
            ]
        ]);
    }

    public function testParseUndefinedReference()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Undefined reference: foobar');

        $parser = new Parser(
            $this->createCompareOperatorProviderMock(['$eq']),
            $this->createLogicalOperatorProviderMock(),
            $this->createSymbolTableMock(['foo'])
        );

        $parser->parse([
            'foobar' => [
                '$eq' => 'bar'
            ]
        ]);
    }

    public function testParseCompareExprWithDefaultOperator()
    {
        $parser = new Parser(
            $this->createCompareOperatorProviderMock(['$eq'], '$eq'),
            $this->createLogicalOperatorProviderMock(),
            $this->createSymbolTableMock(['foo'])
        );

        $expected = new NodeMock('cmp', [
            '$eq', [
                new NodeMock('ref', ['foo']),
                new NodeMock('val', ['bar'])
            ]
        ]);

        $this->assertEquals($expected, $parser->parse([
            'foo' => 'bar'
        ]));
    }

    public function testParseLogicalExpr()
    {
        $parser = new Parser(
            $this->createCompareOperatorProviderMock(['$eq']),
            $this->createLogicalOperatorProviderMock(['$and']),
            $this->createSymbolTableMock(['foo'])
        );

        $expected = new NodeMock('log', [
            '$and', [
                new NodeMock('cmp', [
                    '$eq', [
                        new NodeMock('ref', ['foo']),
                        new NodeMock('val', ['bar'])
                    ]
                ])
            ]
        ]);

        $this->assertEquals($expected, $parser->parse([
            '$and' => [
                [
                    'foo' => [
                        '$eq' => 'bar'
                    ]
                ]
            ]
        ]));
    }

    private function createCompareOperatorProviderMock(array $operators = [], string $defaultOperator = null)
    {
        $operatorProviderMock = $this->createMock(CompareOperatorProviderInterface::class);
        $operatorProviderMock
            ->method('supports')
            ->willReturnCallback(function ($name) use ($operators) {
                return in_array($name, $operators);
            });

        $operatorProviderMock
            ->method('factory')
            ->willReturnCallback(function ($name, ...$args) {
                return new NodeMock('cmp', [$name, $args]);
            });

        if ($defaultOperator) {
            $operatorProviderMock
                ->method('getDefaultOperator')
                ->willReturn($defaultOperator);
        }

        return $operatorProviderMock;
    }

    private function createLogicalOperatorProviderMock(array $operators = [])
    {
        $operatorProviderMock = $this->createMock(LogicalOperatorProviderInterface::class);
        $operatorProviderMock
            ->method('supports')
            ->willReturnCallback(function ($name) use ($operators) {
                return in_array($name, $operators);
            });

        $operatorProviderMock
            ->method('factory')
            ->willReturnCallback(function (...$args) {
                return new NodeMock('log', $args);
            });


        return $operatorProviderMock;
    }

    private function createSymbolTableMock(array $symbols = [])
    {
        $symbolTableMock = $this->createMock(SymbolTableInterface::class);
        $symbolTableMock
            ->method('getReference')
            ->willReturnCallback(function ($symbol) use ($symbols) {
                if (in_array($symbol, $symbols)) {
                    return new NodeMock('ref', [$symbol]);
                }

                return null;
            });

        $symbolTableMock
            ->method('getValue')
            ->willReturnCallback(function ($symbol, $value) use ($symbols) {
                if (in_array($symbol, $symbols)) {
                    return new NodeMock('val', [$value]);
                }

                return null;
            });

        return $symbolTableMock;
    }
}
