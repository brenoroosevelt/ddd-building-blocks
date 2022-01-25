<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\AlwaysOk;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\ValueObject;
use BrenoRoosevelt\Specification\Specification;

class Integer extends ValueObject
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->validationRules()->validate($value)->guard();
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function format(int $decimals = 0, string $decimalSeparator = ',', string $thousandsSeparator = '.'): string
    {
        return number_format($this->value, $decimals, $decimalSeparator, $thousandsSeparator);
    }

    public function validationRules(): Constraint
    {
        return new AlwaysOk();
    }

    public function is(Specification $specification): bool
    {
        return $specification->isSatisfiedBy($this->value);
    }
}
