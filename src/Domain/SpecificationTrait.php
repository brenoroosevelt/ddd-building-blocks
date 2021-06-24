<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

trait SpecificationTrait
{
    public function is(Specification $specification): bool
    {
        return $specification->isSatisfiedBy($this);
    }
}
