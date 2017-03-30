<?php

namespace AdamWojs\JsonExpr\Tests\Expression;

use AdamWojs\JsonExpr\Expression\LogicalOperator;
use AdamWojs\JsonExpr\Expression\NodeInterface;
use PHPUnit\Framework\TestCase;

abstract class BaseLogicalOperatorTest extends TestCase
{
    public function testConstruct()
    {
        $args = [
            $this->createMock(NodeInterface::class),
            $this->createMock(NodeInterface::class)
        ];

        $operator = $this->createLogicalOperator($args);

        $this->assertEquals($args, $operator->getArgs());
    }

    public function testConstructWithoutMinimumRequiredArguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Minimum 1 argument required.");

        $this->createLogicalOperator([
            // Construct logical operator without arguments
        ]);
    }

    /**
     * Create operator instance.
     *
     * @param array $args
     * @return LogicalOperator
     */
    protected abstract function createLogicalOperator(array $args);
}
