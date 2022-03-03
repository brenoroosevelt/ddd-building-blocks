<?php

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection;

use Countable;
use IteratorAggregate;

class Integers implements IteratorAggregate, Countable
{
    use CollectionTrait {
        add as private _add;
    }

    public function __construct(int ...$values)
    {
        $this->setData(...$values);
    }

    public function add(int ...$values): static
    {
        return $this->_add(...$values);
    }

    public function sum(): int
    {
        return array_sum($this->data);
    }
}
