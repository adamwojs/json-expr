<?php

namespace AdamWojs\FilterBuilder\Expression\Cmp;

use AdamWojs\FilterBuilder\Expression\NodeInterface;

abstract class BinaryComparision implements NodeInterface
{
    /** @var NodeInterface */
    private $first;

    /** @var NodeInterface */
    private $second;

    /**
     * AbstractBinaryOperator constructor.
     *
     * @param NodeInterface $first
     * @param NodeInterface $second
     */
    public function __construct(NodeInterface $first, NodeInterface $second)
    {
        $this->first = $first;
        $this->second = $second;
    }

    public function getFirst(): NodeInterface
    {
        return $this->first;
    }

    public function getSecond(): NodeInterface
    {
        return $this->second;
    }
}
