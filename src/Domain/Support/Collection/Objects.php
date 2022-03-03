<?php

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection;

use Countable;
use IteratorAggregate;

class Objects implements IteratorAggregate, Countable
{
    use CollectionTrait {
        add as private _add;
    }

    public function __construct(object ...$values)
    {
        $this->setData(...$values);
    }

    public function add(object ...$values): static
    {
        return $this->_add(...$values);
    }
}
