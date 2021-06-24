<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

abstract class ValueObject implements Comparable
{
    use Comparison;
    use SpecificationTrait;

    public function equals($v): bool
    {
        return $v instanceof $this && $v == $this;
    }
}
