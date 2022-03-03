<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\Contracts;

interface Addable
{
    public function add(...$data): static;
}
