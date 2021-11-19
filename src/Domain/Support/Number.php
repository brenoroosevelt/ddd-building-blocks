<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\AlwaysOk;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\ValueObject;
use BrenoRoosevelt\Specification\Specification;

class Number extends ValueObject
{
    protected float $value;

    public function __construct(float $value)
    {
        $this->getValidation()->validate($value)->guard();
        $this->value = $value;
    }

    public function value(): float
    {
        return $this->value;
    }

    public function format(int $decimals = 2, string $decimalSeparator = ',', string $thousandsSeparator = '.'): string
    {
        return number_format($this->value, $decimals, $decimalSeparator, $thousandsSeparator);
    }

    public function getValidation(): Constraint
    {
        return new AlwaysOk();
    }

    public function is(Specification $specification): bool
    {
        return $specification->isSatisfiedBy($this->value);
    }
}
