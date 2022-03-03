<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection;

use ArrayIterator;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\Traits\Add;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\Traits\Data;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\Traits\Merge;

trait CollectionTrait
{
    use Data, Add, Merge;

    public function accept(callable $fn): static
    {
        return $this->instance()->setData(...array_filter($this->data, $fn, ARRAY_FILTER_USE_BOTH));
    }

    public function reject(callable $fn): static
    {
        return $this->accept(fn($v, $k) => !$fn($v, $k));
    }

    public function indexOf($element, bool $strict = true): bool|int|string
    {
        return array_search($element, $this->data, $strict);
    }

    public function remove(...$elements): static
    {
        $data = $this->data;
        foreach ($this->data as $idx => $item) {
            if (in_array($item, $elements, true)) {
                unset($data[$idx]);
            }
        }

        return new static(...$data);
    }

    public function removeByIndex(...$index): static
    {
        $data = $this->data;
        foreach ($index as $idx) {
            unset($data[$idx]);
        }

        return new static(...$data);
    }

    public function reindex(): static
    {
        return new static(...$this->values());
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function each(callable $fn): void
    {
        foreach ($this->data as $key => $value) {
            $fn($value, $key);
        }
    }

    public function map(callable $fn): array
    {
        return array_map($fn, $this->data);
    }

    public function some(callable $fn): bool
    {
        foreach ($this->data as $key => $value) {
            if (true === $fn($value, $key)) {
                return true;
            }
        }

        return false;
    }

    public function all(callable $fn): bool
    {
        foreach ($this->data as $key => $value) {
            if (false === $fn($value, $key)) {
                return false;
            }
        }

        return true;
    }

    public function sumBy(callable $fn, $initial = 0.0)
    {
        foreach ($this->data as $key => $value) {
            $initial += $fn($value, $key);
        }

        return $initial;
    }

    public function groupBy(callable $fn): array
    {
        $groups = [];
        foreach ($this->data as $key => $value) {
            $groups[$fn($value, $key)][] = $value;
        }

        return $groups;
    }

    public function countWhen(callable $fn, int $initial = 0): int
    {
        foreach ($this->data as $key => $value) {
            if (true === $fn($value, $key)) {
                $initial++;
            }
        }

        return $initial;
    }

    public function first()
    {
        foreach ($this->data as $item) {
            return $item;
        }

        return null;
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    public function values(): array
    {
        return array_values($this->data);
    }

    public function keys(): array
    {
        return array_keys($this->data);
    }

    public function hasKey($index): bool
    {
        return array_key_exists($index, $this->data);
    }

    public function contains($element, bool $strict = true): bool
    {
        return in_array($element, $this->data, $strict);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }

    public function unique(): static
    {
        return new static(...$this->makeUnique($this->data));
    }

    public function infiniteLoop(callable $fn): void
    {
        $loop = new \InfiniteIterator(new ArrayIterator($this->data));
        foreach ($loop as $k => $v) {
            if (false === $fn($v, $k)) {
                break;
            }
        }
    }
}
