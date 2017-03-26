<?php

namespace AdamWojs\JsonExpr\Tests\Parser\OperatorProvider;

use AdamWojs\JsonExpr\Parser\Exception\OperatorProviderException;
use AdamWojs\JsonExpr\Parser\OperatorProvider\CompareOperatorProvider;
use PHPUnit\Framework\TestCase;

class CompareOperatorProviderTest extends TestCase
{
    public function testRegister()
    {
        $provider = $this->createOperatorProvider();
        $provider->register('$eq', 'A\B\Eq');
        $provider->register('$lt', 'A\B\Lt');

        $this->assertEquals([
            '$eq' => 'A\B\Eq',
            '$lt' => 'A\B\Lt'
        ], iterator_to_array($provider->getIterator()));
    }

    public function testRegisterDefault()
    {
        $provider = $this->createOperatorProvider();
        $provider->register('$eq', 'A\B\Eq', true);
        $provider->register('$lt', 'A\B\Lt');

        $this->assertEquals($provider->getDefaultOperator(), '$eq');
    }

    public function testChangeDefaultOperator()
    {
        $provider = $this->createOperatorProvider();
        $provider->register('$eq', 'A\B\Eq', true);
        $provider->register('$eqe', 'A\B\Eqe', true);

        $this->assertEquals($provider->getDefaultOperator(), '$eqe');
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
            '$eq' => 'A\B\Eq'
        ]);
        $provider->register('$eq', 'A\B\C\Eq');
    }

    public function testUnregister()
    {
        $provider = $this->createOperatorProvider([
            '$eq' => 'A\B\Eq',
            '$lt' => 'A\B\Lt'
        ]);
        $provider->unregister('$eq');

        $this->assertEquals([
            '$lt' => 'A\B\Lt'
        ], iterator_to_array($provider->getIterator()));
    }

    public function testUnregisterLast()
    {
        $provider = $this->createOperatorProvider([
            '$eq' => 'A\B\Eq',
        ]);
        $provider->unregister('$eq');

        $this->assertEmpty(iterator_to_array($provider->getIterator()));
    }

    public function testUnregisterNonExisting()
    {
        $this->expectException(OperatorProviderException::class);

        $provider = $this->createOperatorProvider([
            '$eq' => 'A\B\Eq',
            '$lt' => 'A\B\Lt',
            '$gt' => 'A\B\Gt'
        ]);
        $provider->unregister('$lte');
    }

    public function testFactory()
    {
        // TODO: Missing test implementation
    }

    public function testFactoryNonExisting()
    {
        $this->expectException(OperatorProviderException::class);

        $provider = $this->createOperatorProvider([
            '$eq' => 'A\B\Eq',
            '$lt' => 'A\B\Lt',
            '$gt' => 'A\B\Gt'
        ]);

        $provider->factory('$lte', null, null);
    }

    public function testGetIterator()
    {
        $operators = [
            '$eq' => 'A\B\Eq',
            '$lt' => 'A\B\Lt',
            '$gt' => 'A\B\Gt'
        ];

        $iterator = $this
            ->createOperatorProvider($operators)
            ->getIterator();

        $this->assertEquals($operators, iterator_to_array($iterator));
    }

    public function testSupports()
    {
        $provider = $this->createOperatorProvider([
            '$eq' => 'A\B\Eq',
            '$lt' => 'A\B\Lt',
            '$gt' => 'A\B\Gt'
        ]);

        $this->assertTrue($provider->supports('$eq'));
        $this->assertTrue($provider->supports('$lt'));
        $this->assertTrue($provider->supports('$gt'));
    }

    public function testSupportsNonExisting()
    {
        $provider = $this->createOperatorProvider([
            '$eq' => 'A\B\Eq',
            '$lt' => 'A\B\Lt',
            '$gt' => 'A\B\Gt'
        ]);

        $this->assertFalse($provider->supports('$lte'));
    }

    private function createOperatorProvider(array $operators = []): CompareOperatorProvider
    {
        $provider = new CompareOperatorProvider();
        foreach ($operators as $name => $class) {
            $provider->register($name, $class);
        }

        return $provider;
    }
}
