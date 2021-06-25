<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Specification;

interface Specification
{
    public function isSatisfiedBy($candidate): bool;
}
