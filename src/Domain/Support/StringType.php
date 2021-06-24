<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Domain\Support;

use BrenoRoosevelt\DddBuildingBlocks\Domain\ValueObject;

class StringType extends ValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
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
}
