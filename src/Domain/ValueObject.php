<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

abstract class ValueObject implements Comparable
{
    use ComparisonTrait;
    use SpecificationTrait;

    /**
     * @param static $v
     * @return bool
     */
    public function equals($v): bool
    {
        return $v instanceof $this && $v == $this;
    }
}
