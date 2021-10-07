<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Specification;

abstract class CompositeSpecification implements Specification
{
    /** @var Specification[]  */
    protected array $specifications;

    public function __construct(Specification $specification, Specification ...$specifications)
    {
        $this->specifications = [$specification, ...$specifications];
    }

    abstract public function isSatisfiedBy($candidate): bool;
}
