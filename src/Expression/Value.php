<?php

namespace AdamWojs\JsonExpr\Expression;

class Value implements NodeInterface
{
    /** @var mixed */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
