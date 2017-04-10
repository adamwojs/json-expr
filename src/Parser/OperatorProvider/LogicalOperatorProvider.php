<?php

namespace AdamWojs\JsonExpr\Parser\OperatorProvider;

use AdamWojs\JsonExpr\Expression\ExpressionInterface;
use AdamWojs\JsonExpr\Parser\Exception\OperatorProviderException;

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
        if (!$this->isValidName($name)) {
            throw new OperatorProviderException("Invalid operator name: $name");
        }

        if ($this->supports($name)) {
            throw new OperatorProviderException("Logical operator $name is already registered.");
        }

        return $this->operators[$name] = $class;
    }

    /**
     * @inheritdoc
     */
    public function unregister(string $name)
    {
        if (!$this->supports($name)) {
            throw new OperatorProviderException("Unsupported logical operator $name.");
        }

        unset($this->operators[$name]);
    }

    /**
     * @inheritdoc
     */
    public function factory(string $name, $args): ExpressionInterface
    {
        if (!$this->supports($name)) {
            throw new OperatorProviderException("Unsupported logical operator $name.");
        }

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

    private function isValidName(string $name): bool
    {
        return !empty($name);
    }
}
