<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Identity;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\Uuid as UuidValidation;

class Uuid extends Identity
{
    protected string $id;

    final public function __construct(string $id)
    {
        $this->getValidation()->validate($id)->guard();
        $this->id = $id;
    }

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
