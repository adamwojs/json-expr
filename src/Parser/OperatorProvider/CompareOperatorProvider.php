<?php

namespace AdamWojs\FilterBuilder\Parser\OperatorProvider;

use AdamWojs\FilterBuilder\Expression\NodeInterface;

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
        unset($this->operators[$name]);
    }

    /**
     * @inheritdoc
     */
    public function factory(string $name, $ref, $val): NodeInterface
    {
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
}
