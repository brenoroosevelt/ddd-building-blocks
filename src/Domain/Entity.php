<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use BrenoRoosevelt\DDD\BuildingBlocks\Application\DtoAssembler;

abstract class Entity implements Identifiable, Comparable, ToDto
{
    use Comparison;
    use SpecificationTrait;

    protected Identity $id;

    public function getId(): Identity
    {
        return $this->id;
    }

    protected function setIdentity(Identity $id): void
    {
        $this->id = $id;
    }

    public function equals($v): bool
    {
        return $v instanceof $this && $this->getId()->equals($v->getId());
    }

    public function toDTO(DtoAssembler $assembler)
    {
        return $assembler->create(get_object_vars($this));
    }
}
