<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use BrenoRoosevelt\DDD\BuildingBlocks\Application\DtoAssembler;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Specification\SpecificationTrait;

abstract class Entity implements Identifiable, Comparable, ToDto
{
    use Comparison;
    use SpecificationTrait;

    protected Identity $id;

    public function __construct(Identity $id)
    {
        $this->id = $id;
    }

    public function getId(): Identity
    {
        return $this->id;
    }

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
