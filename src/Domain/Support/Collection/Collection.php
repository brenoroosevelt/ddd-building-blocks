<?php

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection;

use Countable;
use IteratorAggregate;

class Collection implements IteratorAggregate, Countable
{
    use CollectionTrait;
//
//    public function __construct(object ...$data)
//    {
//        $this->setData(...$data);
//    }
}
