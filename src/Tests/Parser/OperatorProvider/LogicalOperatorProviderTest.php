<?php

namespace AdamWojs\JsonExpr\Tests\Parser\OperatorProvider;

use AdamWojs\JsonExpr\Parser\Exception\OperatorProviderException;
use AdamWojs\JsonExpr\Parser\OperatorProvider\LogicalOperatorProvider;
use PHPUnit\Framework\TestCase;

class LogicalOperatorProviderTest extends TestCase
{
    public function testRegister()
    {
        $provider = $this->createOperatorProvider();
        $provider->register('$and', 'A\B\C\LogicalAnd');
        $provider->register('$not', 'A\B\C\LogicalNot');

        $this->assertEquals([
            '$and' => 'A\B\C\LogicalAnd',
            '$not' => 'A\B\C\LogicalNot'
        ], iterator_to_array($provider->getIterator()));
    }

    public function testRegisterWithInvalidName()
    {
        $this->expectException(OperatorProviderException::class);

        $provider = $this->createOperatorProvider();
        $provider->register('', 'A\B\C\Empty');
    }

    public function testRegisterDuplicate()
    {
        $this->expectException(OperatorProviderException::class);

        $provider = $this->createOperatorProvider([
            '$and' => 'A\B\LogicalAnd',
        ]);
        $provider->register('$and', 'A\B\C\LogicalAnd');
    }

    public function testUnregister()
    {
        $provider = $this->createOperatorProvider([
            '$and' => 'A\B\LogicalAnd',
            '$not' => 'A\B\LogicalNot'
        ]);
        $provider->unregister('$and');

        $this->assertEquals([
            '$not' => 'A\B\LogicalNot'
        ], iterator_to_array($provider->getIterator()));
    }

    public function testUnregisterLast()
    {
        $provider = $this->createOperatorProvider([
            '$not' => 'A\B\LogicalNot'
        ]);
        $provider->unregister('$not');

        $this->assertEmpty(iterator_to_array($provider->getIterator()));
    }

    public function testUnregisterNonExisting()
    {
        $this->expectException(OperatorProviderException::class);

        $provider = $this->createOperatorProvider([
            '$and' => 'A\B\LogicalAnd',
            '$not' => 'A\B\LogicalNot'
        ]);
        $provider->unregister('$nand');
    }

    public function testFactory()
    {
        // TODO: Missing test implementation
    }

    public function testFactoryNonExisting()
    {
        $this->expectException(OperatorProviderException::class);

        $provider = $this->createOperatorProvider([
            '$and' => 'A\B\LogicalAnd',
            '$not' => 'A\B\LogicalNot'
        ]);
        $provider->factory('$nand', []);
    }

    public function testGetIterator()
    {
        $operators = [
            '$and' => 'A\B\LogicalAnd',
            '$not' => 'A\B\LogicalNot'
        ];

        $iterator = $this
            ->createOperatorProvider($operators)
            ->getIterator();

        $this->assertEquals($operators, iterator_to_array($iterator));
    }

    public function testSupports()
    {
        $provider = $this->createOperatorProvider([
            '$and' => 'A\B\LogicalAnd',
            '$not' => 'A\B\LogicalNot'
        ]);

        $this->assertTrue($provider->supports('$and'));
        $this->assertTrue($provider->supports('$not'));
    }

    public function testSupportsNonExisting()
    {
        $provider = $this->createOperatorProvider([
            '$and' => 'A\B\LogicalAnd',
            '$not' => 'A\B\LogicalNot'
        ]);

        $this->assertFalse($provider->supports('$nand'));
    }

    private function createOperatorProvider(array $operators = []): LogicalOperatorProvider
    {
        $provider = new LogicalOperatorProvider();
        foreach ($operators as $name => $class) {
            $provider->register($name, $class);
        }

        return $provider;
    }
}
