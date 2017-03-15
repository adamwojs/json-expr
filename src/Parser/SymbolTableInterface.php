<?php

namespace AdamWojs\FilterBuilder\Parser;

interface SymbolTableInterface
{
    public function isAllowedId(string $id): bool;
}
