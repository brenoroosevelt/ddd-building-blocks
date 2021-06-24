<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Application;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\ToDto;

abstract class DtoAssembler
{
    public abstract function create(array $data): DataTransferObject;

    public function assemble(ToDto $entity)
    {
        return $entity->toDTO($this);
    }
}
