<?php

namespace AdamWojs\FilterBuilder\Parser;

use AdamWojs\FilterBuilder\Expression\NodeInterface;

class CompareOperatorFactory
{
    /** @var array */
    private $operators;
    /** @var string */
    private $default;

    public function __construct()
    {
        $this->operators = [];
        $this->default = null;
    }

    public function register($name, $class, $default = false)
    {
        $this->operators[$name] = $class;
        if ($default) {
            $this->default = $name;
        }
    }

    public function getDefault(): string
    {
        return $this->default;
    }

    public function factory($name, $id, $value): NodeInterface
    {
        return new $this->operators[$name]($id, $value);
    }

    public function supports($name): bool
    {
        return isset($this->operators[$name]);
    }
}
