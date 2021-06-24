<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Domain;

use BrenoRoosevelt\DddBuildingBlocks\Application\DtoAssembler;

interface ToDto
{
    public function toDTO(DtoAssembler $assembler);
}
