<?php

namespace AdamWojs\JsonExpr\Expression;

interface NodeVisitorInterface
{
    public function visitId(Id $node);

    public function visitValue(Value $node);

    public function visitLogicalOperator(NodeInterface $node);

    public function visitCompareOperator(NodeInterface $node);
}
