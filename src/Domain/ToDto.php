<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use BrenoRoosevelt\DDD\BuildingBlocks\Application\DtoAssembler;

interface ToDto
{
    public function toDTO(DtoAssembler $assembler);
}
