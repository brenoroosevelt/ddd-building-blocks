<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

interface Identity extends Comparable
{
    public function __toString(): string;
}
