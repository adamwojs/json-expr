<?php

namespace AdamWojs\JsonExpr\Tests\Expression;

use AdamWojs\JsonExpr\Expression\ExpressionInterface;
use AdamWojs\JsonExpr\Expression\LogicalOperator;
use PHPUnit\Framework\TestCase;

abstract class BaseLogicalOperatorTest extends TestCase
{
    public function testConstruct()
    {
        $args = [
            $this->createMock(ExpressionInterface::class),
            $this->createMock(ExpressionInterface::class)
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
    abstract protected function createLogicalOperator(array $args);
}
