<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

trait Comparison
{
    public abstract function equals($v): bool;

    public function different($v): bool
    {
        return !$this->equals($v);
    }

    public function isAnyOf(...$v): bool
    {
        foreach ($v as $item) {
            if ($this->equals($item)) {
                return true;
            }
        }

        return false;
    }

    public function isNoneOf(...$v): bool
    {
        return !$this->isAnyOf(...$v);
    }
}
