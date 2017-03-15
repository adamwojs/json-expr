<?php

namespace AdamWojs\FilterBuilder\Parser;

class SymbolTable implements SymbolTableInterface
{
    /** @var array */
    private $symbols;

    public function __construct(array $symbols)
    {
        $this->symbols = $symbols;
    }

    /**
     * @inheritdoc
     */
    public function isAllowedId(string $id): bool
    {
        return in_array($id, $this->symbols);
    }
}
