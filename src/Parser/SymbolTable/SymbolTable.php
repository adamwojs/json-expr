<?php

namespace AdamWojs\JsonExpr\Parser\SymbolTable;

use AdamWojs\JsonExpr\Expression\Id;
use AdamWojs\JsonExpr\Expression\Value;

/**
 * SymbolTable
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
class SymbolTable implements SymbolTableInterface
{
    /** @var array */
    private $symbols;

    public function __construct(array $symbols)
    {
        foreach ($symbols as $id) {
            $this->symbols[$id] = new Id($id);
        }
    }

    /**
     * @inheritdoc
     */
    public function getReference(string $id)
    {
        if (isset($this->symbols[$id])) {
            return $this->symbols[$id];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getValue(string $id, $value)
    {
        return new Value($value);
    }
}
