<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Identity;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

class Uuid extends StringLiteral implements Identity
{
    public static function new(string $value = null): self
    {
        return new self($value ?? \Ramsey\Uuid\Uuid::uuid4()->toString());
    }

    public function validationRules(): Constraint
    {
        return new Constraints\Uuid();
    }
}
