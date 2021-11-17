<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Identity;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\UuidValidator as UuidValidation;

class Uuid extends StringLiteral implements Identity
{
    protected string $id;

    public static function new(string $value = null)
    {
        return new static($value ?? \Ramsey\Uuid\Uuid::uuid4()->toString());
    }

    public function value(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function getValidation(): Constraint
    {
        return new UuidValidation();
    }
}
