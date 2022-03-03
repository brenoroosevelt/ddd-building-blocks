<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\Traits;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\Behaviour\Immutable;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\Behaviour\Uniqueness;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\Contracts\Storage;

trait Data
{
    private array $data = [];

    public function __construct(...$data)
    {
        $this->setData(...$data);
    }

    public function withData(...$data): static
    {
        if ($this instanceof Immutable) {
            return new static(...$data);
        }

        $this->setData(...$data);
        return $this;
    }

    protected function setData(...$data): void
    {
        $this->data = $this instanceof Uniqueness ? $this->makeUnique($data) : $data;
    }

    private function makeUnique(array $data): array
    {
        return array_filter(
            $data,
            fn($v, $k) => array_search($v, $data, true) === $k,
            ARRAY_FILTER_USE_BOTH
        );
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
