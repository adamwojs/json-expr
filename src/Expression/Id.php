<?php

namespace AdamWojs\JsonExpr\Expression;

class Id implements NodeInterface
{
    /** @var string */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function accept(NodeVisitorInterface $visitor)
    {
        return $visitor->visitId($this);
    }
}
