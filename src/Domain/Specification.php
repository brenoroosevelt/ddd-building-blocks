<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Domain;

interface Specification
{
    public function isSatisfiedBy($candidate): bool;
}
