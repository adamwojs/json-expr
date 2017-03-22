<?php

namespace AdamWojs\FilterBuilder\Parser\SymbolTable;

/**
 * SymbolTableInterface
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
interface SymbolTableInterface
{
    public function getReference(string $id);

    public function getValue(string $id, $value);
}
