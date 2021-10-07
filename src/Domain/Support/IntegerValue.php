<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\AlwaysOk;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\ValueObject;

class IntegerValue extends ValueObject
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->getValidation()->validate($value)->guard();
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

    public function getValidation(): Constraint
    {
        return new AlwaysOk();
    }
}
