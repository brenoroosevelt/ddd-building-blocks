<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Specification\SpecificationTrait;


abstract class ValueObject implements Comparable
{
    use Comparison;
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
