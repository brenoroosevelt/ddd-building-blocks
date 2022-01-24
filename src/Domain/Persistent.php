<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

interface Persistent
{
    public static function fromPersistence(array $record): static;
    public static function toPersistence(): array;
}
