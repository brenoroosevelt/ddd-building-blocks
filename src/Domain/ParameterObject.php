<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use DateTimeImmutable;

interface ParameterObject
{
    public function has(string $key): bool;
    public function get(string $key, $default = null): mixed;
    public function getString(string $key, ?string $default = null): ?string;
    public function getInt(string $key, ?int $default = null): ?int;
    public function getFloat(string $key, ?float $default = null): ?float;
    public function getBoolean(string $key, ?bool $default = null): ?bool;
    public function getDateTime(string $key, ?string $default = null): ?DateTimeImmutable;
}
