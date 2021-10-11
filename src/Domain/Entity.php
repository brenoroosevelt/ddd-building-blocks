<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use BrenoRoosevelt\DDD\BuildingBlocks\Application\DtoAssembler;

abstract class Entity implements Identifiable, Comparable, ToDto
{
    use ComparisonTrait;
    use SpecificationTrait;

    /**
     * @param static $v
     * @return bool
     */
    public function equals($v): bool
    {
        return $v instanceof $this && $this->getId()->equals($v->getId());
    }

    public function toDTO(DtoAssembler $assembler)
    {
        return $assembler->create(get_object_vars($this));
    }
}
