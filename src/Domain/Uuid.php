<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

class Uuid extends Identity
{
    protected string $id;

    final public function __construct(string $id)
    {
        if (!\Ramsey\Uuid\Uuid::isValid($id)) {
            throw new \DomainException("Invalid UUID: $id");
        }

        $this->id = $id;
    }

    public static function new()
    {
        return new static(\Ramsey\Uuid\Uuid::uuid4()->toString());
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
