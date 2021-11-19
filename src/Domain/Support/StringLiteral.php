<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\AlwaysOk;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\ValueObject;
use BrenoRoosevelt\Specification\Specification;

class StringLiteral extends ValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->getValidation()->validate($value)->guard();
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getValidation(): Constraint
    {
        return new AlwaysOk();
    }

    public function isTheValue(Specification $specification): bool
    {
        return $specification->isSatisfiedBy($this->value);
    }
}
