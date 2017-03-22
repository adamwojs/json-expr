<?php

namespace AdamWojs\FilterBuilder\Parser;

use AdamWojs\FilterBuilder\Expression\NodeInterface;

class LogicalOperatorFactory
{
    /** @var array */
    private $operators;

    public function __construct()
    {
        $this->operators = [];
    }

    public function register(string $name, $class)
    {
        return $this->operators[$name] = $class;
    }

    public function supports(string $name): bool
    {
        return isset($this->operators[$name]);
    }

    public function factory($name, $args): NodeInterface
    {
        return new $this->operators[$name](...$args);
    }
}
