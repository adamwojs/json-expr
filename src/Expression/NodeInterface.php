<?php

namespace AdamWojs\JsonExpr\Expression;

interface NodeInterface
{
    public function accept(NodeVisitorInterface $visitor);
}
