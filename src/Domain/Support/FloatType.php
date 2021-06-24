<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Domain\Support;

use BrenoRoosevelt\DddBuildingBlocks\Domain\ValueObject;

class FloatType extends ValueObject
{
    protected float $value;

    public function __construct(float $value)
    {
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
}
