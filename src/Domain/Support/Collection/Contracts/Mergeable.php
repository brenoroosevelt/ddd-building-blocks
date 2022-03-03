<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\Contracts;

interface Mergeable
{
    /**
     * @param self $other
     * @return static
     * @throws \InvalidArgumentException if the other is not of the same class as this instance
     */
    public function merge(self $other): static;
}
