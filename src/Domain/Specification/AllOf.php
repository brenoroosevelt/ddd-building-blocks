<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Specification;

class AllOf implements Specification
{
    /** @var Specification[]  */
    protected array $specifications;

    public function __construct(Specification $specification, Specification ...$specifications)
    {
        $specifications[] = $specification;
        $this->specifications[] = $specifications;
    }

    public function isSatisfiedBy($candidate): bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($candidate)) {
                return false;
            }
        }

        return true;
    }
}
