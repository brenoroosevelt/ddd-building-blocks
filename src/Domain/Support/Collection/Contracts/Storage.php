<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\Contracts;

interface Storage
{
    public function put($value, $index = null): void;
    public function get($index = null): void;
    public function removeByIndex($index): void;
    public function removeElement($element): void;
    public function all(): iterable;
    public function copy(): self;
}
