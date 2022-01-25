<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\AlwaysOk;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\ValueObject;
use BrenoRoosevelt\Specification\Specification;
use function BrenoRoosevelt\Specification\greaterThan;
use function BrenoRoosevelt\Specification\lessThan;

class Number extends ValueObject
{
    protected float $value;

    public function __construct(float $value)
    {
        $this->validationRules()->validate($value)->guard();
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

    public function validationRules(): Constraint
    {
        return new AlwaysOk();
    }

    public function is(Specification $specification): bool
    {
        return $specification->isSatisfiedBy($this->value);
    }

    public static function positive(): Specification
    {
        return greaterThan(0);
    }

    public static function negative(): Specification
    {
        return lessThan(0);
    }
}
