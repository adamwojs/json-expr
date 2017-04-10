<?php

namespace AdamWojs\JsonExpr\Parser\OperatorProvider;

use AdamWojs\JsonExpr\Expression\ExpressionInterface;
use AdamWojs\JsonExpr\Parser\Exception\OperatorProviderException;

class CompareOperatorProvider implements CompareOperatorProviderInterface
{
    /** @var array Operators list */
    private $operators;
    /** @var string Default operator name */
    private $defaultOperator;

    public function __construct()
    {
        $this->operators = [];
        $this->defaultOperator = null;
    }

    /**
     * @inheritdoc
     */
    public function register(string $name, string $class, bool $isDefault = false)
    {
        if (!$this->isValidName($name)) {
            throw new OperatorProviderException("Invalid operator name: $name");
        }

        if ($this->supports($name)) {
            throw new OperatorProviderException("Compare operator $name is already registered.");
        }

        $this->operators[$name] = $class;
        if ($isDefault) {
            $this->defaultOperator = $name;
        }
    }

    /**
     * @inheritdoc
     */
    public function unregister(string $name)
    {
        if (!$this->supports($name)) {
            throw new OperatorProviderException("Unsupported compare operator $name.");
        }

        unset($this->operators[$name]);
    }

    /**
     * @inheritdoc
     */
    public function factory(string $name, $ref, $val): ExpressionInterface
    {
        if (!$this->supports($name)) {
            throw new OperatorProviderException("Unsupported compare operator $name.");
        }

        return new $this->operators[$name]($ref, $val);
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
    public function getDefaultOperator(): string
    {
        return $this->defaultOperator;
    }

    /**
     * @inheritdoc
     */
    public function supports(string $name): bool
    {
        return isset($this->operators[$name]);
    }

    private function isValidName($name): bool
    {
        return !empty($name);
    }
}
