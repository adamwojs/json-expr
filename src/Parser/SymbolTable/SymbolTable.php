<?php

namespace AdamWojs\FilterBuilder\Parser\SymbolTable;

use AdamWojs\FilterBuilder\Expression\Id;
use AdamWojs\FilterBuilder\Expression\Value;

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
