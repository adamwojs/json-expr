<?php

namespace AdamWojs\JsonExpr\Parser\OperatorProvider;

use AdamWojs\JsonExpr\Expression\NodeInterface;

interface CompareOperatorProviderInterface
{
    public function register(string $name, string $class, bool $isDefault = false);

    public function unregister(string $name);

    public function getIterator(): \Iterator;

    public function getDefaultOperator(): string;

    public function factory(string $name, $ref, $val): NodeInterface;

    public function supports(string $name): bool;
}
