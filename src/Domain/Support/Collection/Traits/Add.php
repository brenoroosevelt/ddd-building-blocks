<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\Traits;

trait Add
{
    use Data;

    public function add(...$data): static
    {
        return $this->withData(...$this->data, ...$data);
    }
}
