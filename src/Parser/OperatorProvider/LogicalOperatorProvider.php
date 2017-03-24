<?php

namespace AdamWojs\JsonExpr\Parser\OperatorProvider;

use AdamWojs\JsonExpr\Expression\NodeInterface;

class LogicalOperatorProvider implements LogicalOperatorProviderInterface
{
    /** @var array Operators list */
    private $operators;

    public function __construct()
    {
        $this->operators = [];
    }

    /**
     * @inheritdoc
     */
    public function register(string $name, $class)
    {
        return $this->operators[$name] = $class;
    }

    /**
     * @inheritdoc
     */
    public function unregister(string $name)
    {
        unset($this->operators[$name]);
    }

    /**
     * @inheritdoc
     */
    public function factory(string $name, $args): NodeInterface
    {
        return new $this->operators[$name](...$args);
    }

    /**
     * @inheritdoc
     */
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->operators);
    }

    /**
     * @inheritdoc
     */
    public function supports(string $name): bool
    {
        return isset($this->operators[$name]);
    }
}
