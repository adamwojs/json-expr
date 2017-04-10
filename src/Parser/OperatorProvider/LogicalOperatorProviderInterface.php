<?php

namespace AdamWojs\JsonExpr\Parser\OperatorProvider;

use AdamWojs\JsonExpr\Expression\ExpressionInterface;

interface LogicalOperatorProviderInterface
{
    public function register(string $name, $class);

    public function unregister(string $name);

    public function getIterator(): \Iterator;

    public function supports(string $name): bool;

    public function factory(string $name, $args): ExpressionInterface;
}
